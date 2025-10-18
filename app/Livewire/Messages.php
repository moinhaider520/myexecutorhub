<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class Messages extends Component
{
    use WithFileUploads;
    public $message = "";
    public $allmessages;
    public $sender;
    public $file;
    public $search = '';

    public function render()
    {
        $roles = ['executor', 'Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'];
        $user = Auth::user();
        $baseQuery = User::query()->with('roles');
        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $users = collect([]);

        if ($user->hasRole('customer')) {

            $customerQuery = clone $baseQuery;

            $users = $customerQuery
                ->where('created_by', $user->id)
                ->whereHas('roles', function ($q) use ($roles) {
                    $q->whereIn('name', $roles);
                })
                ->get();

            $adminUsers = User::role('admin')
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->get();
            $users = $users->merge($adminUsers);
        } elseif ($user->hasRole('partner')) {

            $users =  User::role('admin')
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->get();
        } else if ($user->hasAnyRole($roles)) {
            $users = User::where('id', $user->created_by)->get();
        } else {
            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['customer', 'partner']);
            })
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->get();
        }

        $sender = $this->sender;
        $this->allmessages;
        return view('livewire.messages', compact('users', 'sender'));
    }
    public function mountdata()
    {

        if (isset($this->sender->id)) {
            $this->allmessages = Message::where('user_id', auth()->id())
                ->where('receiver_id', $this->sender->id)
                ->orWhere('user_id', $this->sender->id)
                ->where('receiver_id', auth()->id())
                ->orderBy('id', 'asc')->get();

            $not_seen = Message::where('user_id', $this->sender->id)->where('receiver_id', auth()->id());
            $not_seen->update(['is_seen' => true]);
        }
    }


    public function SendMessage()
    {

        $data = new Message;
        $data->message = $this->message;
        $data->user_id = auth()->id();
        $data->receiver_id = $this->sender->id;
        if ($this->file) {
            $file = $this->file->store('public/files');
            $path = url(Storage::url($file));
            $data->attachment = $path;
        }
        $data->save();

        $this->resetForm();
    }
    public function resetForm()
    {
        $this->message = '';
    }
    public function getUser($userId)
    {

        $user = User::find($userId);
        $this->sender = $user;
        $this->allmessages = Message::where('user_id', auth()->id())
            ->where('receiver_id', $userId)
            ->orWhere('user_id', $userId)
            ->where('receiver_id', auth()->id())
            ->orderBy('id', 'asc')->get();
    }
}
