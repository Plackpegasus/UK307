<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>New Order</title>
    <link rel="stylesheet" href="public/css/app.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">

    <!-- Customen css !-->
    <link rel="stylesheet" href="./css/main.css">

    <!-- Bootstrap javascript !-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>

</head>
<body>

<!-- Main !-->
<div class="container">
    <div class="row">
        <div class="col">
            <form id="create-order" action="NEWORDER" method="post">
                <fieldset>
                    <legend>Eintrag erstellen</legend>
                    <div>
                        <label for="user-name">Name:</label>
                        <input name="user-name" type="text" placeholder="Vorname, Nachname" required autofocus>
                    </div>
                    <div>
                        <label for="user-email">Email-Addresse:</label>
                        <input id="user-email" name="user-email" type="email" placeholder="max.muster@gmail.com" required autofocus>
                    </div>
                    <div>
                        <label for="user-phonenumber">Telephonenummer:</label>
                        <input name="user-phonenumber" type="text" placeholder="123 456 78 90">
                    </div>
                    <div>
                        <label>Prozente:</label>
                        <select id="prozent" name="procends" required autofocus>
                            <?php echo getRenderdHtml(getProcentText());?>
                        </select>
                    </div>
                    <div>
                        <label>Konzert:</label>
                        <select id="conzertds" name="conzertds" required autofocus>
                            <?php echo getRenderdHtml(getConzertName());?>
                        </select>
                    </div><br>
                    <div>
                        <label for="time-to-pay">Zahlung bis:</label><b><a id="time-to-pay"></a></b>
                        <br><input name="create" type="submit" value="Erstellen">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="public/js/app.js"></script>

</body>
</html>
