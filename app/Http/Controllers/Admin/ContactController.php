<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by purpose
        if ($request->has('purpose') && $request->purpose != '') {
            $query->where('purpose', $request->purpose);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $contacts = $query->paginate(15)->withQueryString();

        // Stats untuk filter dan header
        $totalCount = Contact::count();
        $unreadCount = Contact::where('status', 'unread')->count();
        $readCount = Contact::where('status', 'read')->count();
        $repliedCount = Contact::where('status', 'replied')->count();

        return view('admin.contacts.index', compact(
            'contacts',
            'totalCount',
            'unreadCount',
            'readCount',
            'repliedCount'
        ));
    }

    public function show($id)
    {
        try {
            $contact = Contact::findOrFail($id);

            // Update status menjadi read ketika dilihat
            if ($contact->status == 'unread') {
                $contact->update(['status' => 'read']);

                Log::info('Contact marked as read', [
                    'contact_id' => $contact->id,
                    'customer_name' => $contact->name,
                    'marked_by' => auth()->id()
                ]);
            }

            return view('admin.contacts.show', compact('contact'));

        } catch (\Exception $e) {
            Log::error('Error showing contact: ' . $e->getMessage(), [
                'contact_id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('admin.contacts.index')
                ->with('error', 'Pesan tidak ditemukan.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied'
        ]);

        try {
            $contact = Contact::findOrFail($id);
            $oldStatus = $contact->status;
            $contact->update(['status' => $request->status]);

            Log::info('Contact status updated', [
                'contact_id' => $contact->id,
                'customer_name' => $contact->name,
                'from_status' => $oldStatus,
                'to_status' => $request->status,
                'updated_by' => auth()->id()
            ]);

            // Response untuk AJAX / JSON request
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diubah menjadi ' . $request->status,
                    'status' => $request->status
                ]);
            }

            // Redirect back dengan pesan sukses
            return redirect()->route('admin.contacts.show', $contact)
                ->with('success', 'Status berhasil diubah dari ' . $oldStatus . ' menjadi ' . $request->status);

        } catch (\Exception $e) {
            Log::error('Error updating contact status: ' . $e->getMessage(), [
                'contact_id' => $id,
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal mengupdate status pesan.');
        }
    }

    /**
     * Standard REST update method for resource route
     */
    public function update(Request $request, $id)
    {
        return $this->updateStatus($request, $id);
    }

    /**
     * Mark single contact as read
     */
    public function markAsRead($id)
    {
        try {
            $contact = Contact::findOrFail($id);

            if ($contact->status == 'unread') {
                $contact->update(['status' => 'read']);

                Log::info('Contact marked as read via quick action', [
                    'contact_id' => $contact->id,
                    'customer_name' => $contact->name,
                    'marked_by' => auth()->id()
                ]);

                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Pesan telah ditandai sebagai dibaca.'
                    ]);
                }

                return redirect()->back()
                    ->with('success', 'Pesan telah ditandai sebagai dibaca.');
            }

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan sudah dalam status dibaca.'
                ]);
            }

            return redirect()->back()
                ->with('info', 'Pesan sudah dalam status dibaca.');

        } catch (\Exception $e) {
            Log::error('Error marking contact as read: ' . $e->getMessage(), [
                'contact_id' => $id
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menandai pesan sebagai dibaca.');
        }
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            $contactData = [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'status' => $contact->status
            ];

            $contact->delete();

            Log::info('Contact deleted', [
                'contact_data' => $contactData,
                'deleted_by' => auth()->id()
            ]);

            return redirect()->route('admin.contacts.index')
                ->with('success', 'Pesan berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error deleting contact: ' . $e->getMessage(), [
                'contact_id' => $id
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus pesan.');
        }
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        try {
            $unreadCount = Contact::where('status', 'unread')->count();

            if ($unreadCount > 0) {
                Contact::where('status', 'unread')->update(['status' => 'read']);

                Log::info('All contacts marked as read', [
                    'count' => $unreadCount,
                    'marked_by' => auth()->id()
                ]);

                return redirect()->back()
                    ->with('success', $unreadCount . ' pesan telah ditandai sebagai dibaca.');
            }

            return redirect()->back()
                ->with('info', 'Tidak ada pesan yang belum dibaca.');

        } catch (\Exception $e) {
            Log::error('Error marking all as read: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menandai semua pesan sebagai dibaca.');
        }
    }

    /**
     * Alias for markAllAsRead to match route definition
     */
    public function markAllRead()
    {
        return $this->markAllAsRead();
    }

    /**
     * Bulk actions (delete multiple contacts)
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_read,mark_replied',
            'contacts' => 'required|array',
            'contacts.*' => 'exists:contacts,id'
        ]);

        try {
            $contactIds = $request->contacts;
            $action = $request->action;
            $count = count($contactIds);

            switch ($action) {
                case 'delete':
                    Contact::whereIn('id', $contactIds)->delete();
                    $message = $count . ' pesan berhasil dihapus.';
                    break;

                case 'mark_read':
                    Contact::whereIn('id', $contactIds)->update(['status' => 'read']);
                    $message = $count . ' pesan ditandai sebagai dibaca.';
                    break;

                case 'mark_replied':
                    Contact::whereIn('id', $contactIds)->update(['status' => 'replied']);
                    $message = $count . ' pesan ditandai sebagai sudah dibalas.';
                    break;
            }

            Log::info('Bulk action performed on contacts', [
                'action' => $action,
                'count' => $count,
                'contact_ids' => $contactIds,
                'performed_by' => auth()->id()
            ]);

            return redirect()->back()
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error performing bulk action: ' . $e->getMessage(), [
                'action' => $request->action,
                'contact_ids' => $request->contacts
            ]);

            return redirect()->back()
                ->with('error', 'Gagal melakukan aksi bulk.');
        }
    }

    /**
     * Get contact statistics for dashboard
     */
    public function getStats()
    {
        try {
            $stats = [
                'total' => Contact::count(),
                'unread' => Contact::where('status', 'unread')->count(),
                'read' => Contact::where('status', 'read')->count(),
                'replied' => Contact::where('status', 'replied')->count(),
                'today' => Contact::whereDate('created_at', today())->count(),
                'this_week' => Contact::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                'this_month' => Contact::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting contact stats: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'error' => 'Gagal mengambil statistik kontak'
            ], 500);
        }
    }
}
