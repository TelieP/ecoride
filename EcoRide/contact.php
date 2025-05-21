<?php
require_once 'includes/header.php';
require_once 'includes/connect.php';
?>

<div class="col-md-9 my-2 d-flex">

    <form class="form-group">
        <div>
            <div>
                <h4>RESTONS EN CONTACT</h4>

            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Adresse mail</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Votre prenom et nom</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Doe John">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">saisissez votre message ici</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>


        </div>
        <button type="submit">Envoyer</button>
    </form>

    <div>
        <p>Adresse: 123 rue de la paix</p>
        <p>Telephone: 01 23 45 67 89</p>
        <p>Email:contact-ecoride@ecoride.fr

    </div>


</div>


<?php
require_once 'includes/footer.php';
?>