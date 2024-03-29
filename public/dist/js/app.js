$(function() {
  var $form = $('payment-form');
  $form.submit(function(event){
      $form.find('.submit').prop('disable', true);

      Stripe.card.createToken($form, stripeResponseHandler);

      return false;
  });
});

function stripeResponseHandler(status, response) {
  var $form = $('#payment-form');

  if (response.error) {
    $form.find('.payment-errors').text(response.error.message);
    $form.find('.submit').prop('disable', false);
  } else {
    var token = response.id;

    $form.append($('<input type="hidden" name="stripeToken">').val(token));

    $form.get(0).submit();
  }
}
