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

    public function render()
    {
        $roles = ['executor', 'Solicitors', 'Accountants', 'Stock Brokers', 'Will Writers', 'Financial Advisers'];

        if (Auth::user()->hasRole('customer')) {

            $user = Auth::user();
            $users = User::with('roles')
                ->where('created_by', $user->id)
                ->whereHas('roles', function ($query) use ($roles) {
                    $query->whereIn('name', $roles);
                })
                ->get();
            $adminUsers = User::role('Admin')->get();
            $users = $users->merge($adminUsers);
        } elseif (Auth::user()->hasRole('partner')) {
            $user = Auth::user();
            $users = User::with('roles')
                ->where('created_by', $user->id)
                ->whereHas('roles', function ($query) use ($roles) {
                    $query->whereIn('name', $roles);
                })
                ->get();
        } else if (Auth::user()->hasAnyRole($roles)) {
            // For users with any of the specified roles
            $user = Auth::user();
            $users = User::where('id', $user->created_by)->get();
        } else {
            // For users who don't match any of the conditions above
            $users = User::all();
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
