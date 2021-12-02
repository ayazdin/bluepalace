 <!DOCTYPE HTML>
    <html>
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    </head>
    <body>
     <form id="myContainer" method="post" action="ec_call.php" accept-charset="UTF-8">

    </form>
         <script>
            window.paypalCheckoutReady = function() {
                paypal.checkout.setup('S4X5XW328WAYY', {
                    container: 'myContainer', 
                    environment: 'sandbox'
                    // button: 'incontext_id'

                });

            }

        </script>
    </body>
<script src="//www.paypalobjects.com/api/checkout.js" async></script>
</html>