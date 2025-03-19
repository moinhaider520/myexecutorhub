<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style type="text/css">
        #card-element {
            height: 50px;
            padding-top: 16px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card mt-5">
                    <div class="card-body">

                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if (session('stripe_error'))
                        <div class="alert alert-danger">
                            {{ session('stripe_error') }}
                        </div>
                        @endif

                        <form id='checkout-form' method='post' action="{{ route('stripe.post') }}">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Name:</strong>
                                    <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                                </div>
                            </div>

                            <!-- Password Field (Initially Hidden) -->
                            <div class="mt-3">
                                <strong>Password:</strong>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Address Line 1:</strong>
                                    <input type="text" class="form-control" name="address_line1" placeholder="Enter Address Line 1" required>
                                </div>
                                <div class="col-md-6">
                                    <strong>City:</strong>
                                    <input type="text" class="form-control" name="city" placeholder="Enter City" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <strong>Postal Code:</strong>
                                    <input type="text" class="form-control" name="postal_code" placeholder="Enter Postal Code" required>
                                </div>
                                <div class="col-md-6">
                                    <strong>Country:</strong>
                                    <input type="text" class="form-control" name="country" placeholder="Enter Country" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <strong>Membership:</strong>
                                    <select class="form-control" id="inputState" name="plan"  required>
                                        <option selected="" disabled>Choose...</option>
                                        <option value="price_1R4UE4SBn09iuv4xvH0KeSEJ">Basic</option>
                                        <option value="price_1R4UEjSBn09iuv4xIez1NWXm">Standard</option>
                                        <option value="price_1R4UFCSBn09iuv4xWmFqEjqr">Premium</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Coupon Code Field -->
                            <div class="mb-3 mt-3">
                                <strong>Use Coupon Code (Optional):</strong>
                                <input type="text" class="form-control" name="coupon_code" placeholder="Enter Coupon Code">
                            </div>
                            <button id='pay-btn' class="btn btn-success mt-3" type="submit" style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
