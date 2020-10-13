<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://widget.cloudpayments.ru/bundles/checkout"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <form id="paymentFormSample" class="form-group">
            <input type="text" data-cp="cardNumber" class="form-control mt-1 col-6" placeholder="Номер карты" id="cardNumber">
            <div class="form-row p-auto m-auto mt-1">
                <input type="text" data-cp="expDateMonth" class="form-control col-3" placeholder="Месяц">
                <input type="text" data-cp="expDateYear" class="form-control col-3" placeholder="Год">
            </div>

            <input type="text" data-cp="cvv" class="form-control mt-1 col-6" placeholder="СММ">
            <input type="text" data-cp="name" class="form-control mt-1 col-6" id="name" placeholder="ФИО">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="saveCard">
                <label class="form-check-label" for="saveCard">Запомнить</label>
            </div>
            <a onclick="createCryptogram()" class="btn btn-primary mt-1">Оплатить 100 р.</a>
        </form>
        <form name="downloadForm" action="AcsUrl" method="POST" class="d-none">
            <input type="hidden" name="PaReq" value="" id="PaReq">
            <input type="hidden" name="MD" value="" id="MD">
            <input type="hidden" name="TermUrl" value="http://test.antitrening/3dsec.php">
        </form>
    </div>

    <script>
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        function createCryptogram() {
       
            if ($('#saveCard:checked')==true) {
           
                document.cookie = "card=" + $('#cardNumber').val();
            }else{
           
                document.cookie ="card=;expires=Thu; 01 Jan 1970";
            }
            var result = checkout.createCryptogramPacket();
            $("#cardNumber").val(getCookie('card'));
            if (result.success) {
                // сформирована криптограмма
                alert(result.packet);
                $.ajax({
                    url: './chekout.php',
                    dataType: 'json',
                    type: "POST",
                    data: {
                        name: $("#name").attr('data-cp'),
                        CardCryptogramPacket: result.packet,
                    },
                    success: function(data) {
                        
                        if (data.status == 0 || data.status == 1) {
                            alert(data.message);
                        } else {
                            alert("вы будете переотправлены на сайт банка");
                            PaReq.value = data.token;
                            MD.value = data.id;
                            downloadForm.action = data.url;

                            downloadForm.submit();
                        }
                        console.log(data);
                    },

                });
            } else {
                // найдены ошибки в введённых данных, объект `result.messages` формата: 
                // { name: "В имени держателя карты слишком много символов", cardNumber: "Неправильный номер карты" }
                // где `name`, `cardNumber` соответствуют значениям атрибутов `<input ... data-cp="cardNumber">`
                for (var msgName in result.messages) {
                    alert(result.messages[msgName]);
                }
            }
        };

        $(function() {
            /* Создание checkout */
            checkout = new cp.Checkout(
                // public id из личного кабинета
                "pk_f90e0b450a2f4765b099043a011e0",
                // тег, содержащий поля данных карты
                document.getElementById("paymentFormSample"));
        });
        $("#cardNumber").val(getCookie('card'));
    </script>
</body>

</html>