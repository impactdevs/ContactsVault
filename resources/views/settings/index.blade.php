@extends('app')
@section('content')
    <div class="container mt-3 mb-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="/update-settings" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group p-3">
                                <label for="company_name">Company Name:</label>
                                <input type="text" name="company_name" id="company_name" class="form-control shadow-none"
                                    value="{{ $setting->company_name ?? '' }}">
                            </div>
                            <div class="form-group p-3">
                                <p>Company Logo</p>
                                <label for="company_logo">
                                    @if ($setting->company_logo_path)
                                        <img src="{{ asset('images/' . $setting->company_logo_path) }}" alt="Company Logo"
                                            height="10%" width="10%" class="img-fluid mt-3">
                                    @else
                                        {{-- UPLOAD COMPANY LOGO --}}
                                        <img src="{{ asset('assets/img/upload.png') }}" alt="upload placeholder" height="50%"
                                            width="50%" class="img-fluid mt-3">
                                    @endif
                                </label>
                                <input type="file" name="company_logo" id="company_logo" class="form-control"
                                    style="display:none;">
                                <div id="passwordHelpBlock" class="form-text">
                                    The should be a JPG, or PNG
                                </div>

                                {{-- show the image --}}

                            </div>
                            <div class="form-group p-3">
                                <label for="company_phone_number">Company Phone Number(s):</label>
                                <input type="text" name="company_phone_number" id="company_phone_number"
                                    class="form-control shadow-none" value="{{ $setting->company_phone_number ?? '' }}">
                            </div>
                            <div class="form-group p-3">
                                <label for="company_email">Company Email(s):</label>
                                <input type="email" name="company_email" id="company_email"
                                    class="form-control shadow-none" value="{{ $setting->company_email ?? '' }}">
                            </div>
                            <div class="form-group p-3">
                                <label for="fb_messenger_username">Facebook Messenger Username</label>
                                <input type="text" name="fb_messenger_username" id="fb_messenger_username"
                                    class="form-control shadow-none" value="{{ $setting->fb_messenger_username ?? '' }}">
                            </div>
                            <div class="form-group p-3">
                                <label for="twitter_username">X(formerly Twitter) Username:</label>
                                <input type="text" name="twitter_username" id="twitter_username"
                                    class="form-control shadow-none" value="{{ $setting->twitter_username ?? '' }}">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12 pt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center">Message Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="/update-settings" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group p-3">
                                <label for="site_name">Message Lapse Time(Hours):</label>
                                <input type="text" name="lapse_time" id="site_name" class="form-control shadow-none"
                                    value="{{ $setting->lapse_time ?? '' }}">
                            </div>
                            <div class="form-group p-3">
                                <label for="site_name">Message Follow Up Time(Hours):</label>
                                <input type="text" name="followup_time" id="site_name" class="form-control shadow-none"
                                    value="{{ $setting->followup_time ?? '' }}">
                            </div>
                            <div class="form-group p-3">
                                <label for="automatic_reply_on_first_received_message">Automatic Reply On First Message
                                    Receipt:</label>
                                <textarea name="automatic_reply_on_first_received_message" id="automatic_reply_on_first_received_message"
                                    class="form-control shadow-none">{{ $setting->automatic_reply_on_first_received_message ?? '' }}</textarea>
                            </div>
                            <div class="form-group p-3">
                                <input class="form-check-input" type="checkbox" name="is_automatic_reply_on"
                                    id="is_automatic_reply_on" {{ $setting->is_automatic_reply_on ? 'checked' : '' }}>
                                <label class="form-check-label shadow-none" for="is_automatic_reply_on">Automatic
                                    Reply</label>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
