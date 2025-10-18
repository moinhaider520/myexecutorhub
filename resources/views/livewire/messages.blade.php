<div class="page-body">

    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-xxl-3 col-xl-4 col-md-5 box-col-5">
                <div class="left-sidebar-wrapper card">
                    <div class="left-sidebar-chat">
                        <div class="input-group"><span class="input-group-text"><i class="search-icon text-gray" data-feather="search"></i></span>
                            <input class="form-control" type="text" placeholder="Search here..">
                        </div>
                    </div>
                    <div class="advance-options">
                        <ul class="nav border-tab" id="chat-options-tab" role="tablist">
                            <li class="nav-item w-100"><a class="nav-link active" id="chats-tab" data-bs-toggle="tab" href="#chats" role="tab" aria-controls="chats" aria-selected="true">Chats</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="chat-options-tabContent">
                            <div class="tab-pane fade show active" id="chats" role="tabpanel" aria-labelledby="chats-tab">
                                <ul class="chats-user" >
                                    @foreach ($users as $user)
                                    @if ($user->id !== auth()->id())
                                        <li  wire:click="getUser({{ $user->id }})">
                                            <div class="chat-time">
                                                <div class="active-profile"><img class="img-fluid rounded-circle" src="{{ $user->profile_image ? asset('assets/upload/'.$user->profile_image) : asset('assets/images/dashboard/profile.png') }}" alt="user">
                                                    @if ($user->is_online)
                                                    <div class="status bg-success"></div>
                                                    @else
                                                    <div class="status bg-danger"></div>
                                                    @endif
                                                </div>
                                                <div> <span>{{ $user->name }}</span>

                                                </div>
                                            </div>
                                            @php
                                            $not_seen_count = App\Models\Message::where(
                                            'user_id',
                                            $user->id,
                                            )
                                            ->where('receiver_id', auth()->id())
                                            ->where('is_seen', false)
                                            ->count();
                                            @endphp
                                            @if ($not_seen_count > 0)
                                            <div>
                                                <div class="badge badge-light-success">{{ $not_seen_count }}
                                                </div>
                                            </div>
                                            @endif
                                        </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-9 col-xl-8 col-md-7 box-col-7">
                <div class="card right-sidebar-chat">
                    <div class="right-sidebar-title">
                        <div class="common-space">
                            <div class="chat-time">
                                @if ($this->sender)
                                <div class="active-profile"><img class="img-fluid rounded-circle" src="{{ $sender->profile_image ? asset('assets/upload/'.$sender->profile_image) : asset('assets/images/dashboard/profile.png')}}" alt="user">
                                    @if ($this->sender->is_online)
                                    <div class="status bg-success"></div>
                                    @else
                                    <div class="status bg-danger"></div>
                                    @endif
                                </div>
                                <div> <span>{{ @$this->sender->name }}</span>
                                    @if ($this->sender->is_online)
                                    <p>Online </p>
                                    @else
                                    <p>Offline </p>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-sidebar-Chats" wire:poll="mountdata">
                        <div class="msger">
                            <div class="msger-chat">
                                @if (filled($allmessages))
                                @foreach ($allmessages as $msg)
                                <div class="msg @if ($msg->user_id == auth()->id()) right-msg  @else left-msg @endif">
                                    @if ($msg->user_id == auth()->id())
                                    <img class="msg-img" src="{{ Auth::user()->profile_image ? asset('assets/upload/' . Auth::user()->profile_image) : asset('assets/images/dashboard/profile.png') }}" alt="user">
                                    @else
                                    <img class="msg-img" src="{{ asset('assets/upload/'.$sender->profile_image) }}" alt="user">
                                    @endif
                                    <div class="msg-bubble">
                                        <div class="msg-info d-block @if ($msg->user_id == auth()->id()) sent @else received @endif">
                                            <div class="msg-info-name">{{ $msg->user->name }}</div>
                                            <div class="msg-text">
                                                {{ $msg->message }}
                                            </div>
                                            @if ($msg->attachment)
                                            <div class="w-100 my-2">
                                                <img class="img-fluid rounded" loading="lazy" style="height: 250px" src="{{ @$msg->attachment }}">
                                            </div>
                                            @endif

                                            <br><small class="msg-info-time">Sent
                                                <em>{{ $msg->created_at }}</em></small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <h2 style="text-align:center;">Please Choose a User to Start the Conversation</h2>
                                @endif
                            </div>
                            @if (!isset($sender))
                            @else
                            <form class="msger-inputarea" wire:submit.prevent="SendMessage">
                                <div class="dropdown-form dropdown-toggle" role="main" aria-expanded="false">
                                    <!-- <label for="fileInput">
                                        <i class="icon-plus"></i>
                                    </label> -->
                                    <input type="file" id="fileInput" wire:model="file" style="display: none;">
                                </div>
                                <input wire:model="message" class="msger-input two uk-textarea" id="messageInput" placeholder="Type Message here.." required>
                                <button class="msger-send-btn"><i class="fa fa-location-arrow"></i></button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->
</div>
