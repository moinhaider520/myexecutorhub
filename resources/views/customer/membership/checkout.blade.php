@extends('layouts.master')

@section('content')
<style>
  .ck-editor__editable_inline {
    min-height: 300px;
  }
</style>
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Executor Hub Membership</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-12 col-sm-12">
                    <form>
                      <div class="row">
                        <div class="mb-3 col-sm-12">
                          <label for="inputEmail4">Full Name</label>
                          <input class="form-control" id="inputEmail4" type="text">
                        </div>
                      </div>
                      <div class="row">
                        <div class="mb-3 col-sm-6">
                          <label for="inputEmail5">Phone</label>
                          <input class="form-control" id="inputEmail5" type="email">
                        </div>
                        <div class="mb-3 col-sm-6">
                          <label for="inputPassword7">Email Address</label>
                          <input class="form-control" id="inputPassword7" type="password">
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="inputState">Membership</label>
                        <select class="form-control" id="inputState" name="plan" onchange="updateAmount()">
                          <option selected="">Choose...</option>
                          <option value="0">Basic</option>
                          <option value="1">Standard</option>
                          <option value="2">Premium</option>
                        </select>
                      </div>

                      <div class="mb-3">
                        <div class="form-group">
                          <label for="amount">Amount (in USD)</label>
                          <input class="form-control" type="number" id="amount" name="amount" value="00.00" required readonly>
                        </div>
                      </div>
                      <div class="mb-3">
                        <div id="card-element" class="form-group">
                          <!-- Stripe Element will be inserted here -->
                        </div>
                      </div>

                      <div class="mb-3">
                        <button class="btn btn-primary" type="button">Place Order</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
  // SECRET KEY is sk_test_51K8pJ0SBn09iuv4x9qgJ99iObq56RHWqziRS8cgYainXSlhy2p3PhcqEH4e8LttkpG3hA6iKQUZDLDBk6Jha2ahM00kFDrouyi
  document.addEventListener("DOMContentLoaded", function () {
    var stripe = Stripe("pk_test_51K8pJ0SBn09iuv4xdBWLGPvi97osXn58uixzt9nAbaE99FXOpo3OlSpOOVOrUEhIft0q2xZKwYZq8uy9SfTs37bp00AgF5o5oo");
    var elements = stripe.elements();
    var style = {
      base: {
        color: "#32325d",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "16px",
        "::placeholder": {
          color: "#aab7c4"
        }
      },
      invalid: {
        color: "#fa755a",
        iconColor: "#fa755a"
      }
    };
    var card = elements.create("card", {
      style: style
    });
    card.mount("#card-element");
    var form = document.getElementById("checkout-form");
    form.addEventListener("submit", function (event) {
      event.preventDefault();
      stripe.createToken(card).then(function (result) {
        if (result.error) {
          var errorElement = document.getElementById("error-message");
          errorElement.textContent = result.error.message;
        } else {
          stripeTokenHandler(result.token);
        }
      });
    });

    function stripeTokenHandler(token) {
      var formData = new FormData(form);
      formData.append("stripeToken", token.id);
      fetch("../functions/stripe/checkout.php", {
        method: "POST",
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            document.getElementById("error-message").textContent = data.error;
          } else {
            if (data.redirect_to_checkout) {
              window.location.href = 'checkout.php';
            } else {
              alert("Payment successful!");
              window.location.href = '../index.php';
            }
          }
        })
        .catch(error => {
          document.getElementById("error-message").textContent = error.message;
        });
    }
  });
</script>

<script>
  function updateAmount() {
    var planSelect = document.querySelector('select[name="plan"]');
    var amountInput = document.querySelector('input[name="amount"]');

    if (planSelect.value == "0") {
      amountInput.value = "8.00";
    } else if (planSelect.value == "1") {
      amountInput.value = "20.00";
    } else {
      amountInput.value = "40.00";
    }
  }
</script>
@endsection