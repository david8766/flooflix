//<![CDATA[
    function getxhr() {
        var xhr = null;

        if( window.XMLHttpRequest ) {
            xhr = new XMLHttpRequest();
        } else if( window.ActiveXObject ) {
            try {
                xhr = new ActiveXObject( 'Msxml2.XMLHTTP' );
            } catch ( e ) {
                xhr = new ActiveXObject( 'Microsoft.XMLHTTP' );
            }
        } else {
            alert( 'Votre navigateur ne supporte pas la technologie AJAX.' );
        }
        console.log( xhr );
        return xhr;
    }

    window.addEventListener( 'load', function(e) {// On attend le chargement complet de la page
        let inputs = document.querySelectorAll( 'input' ); // On récupère tous les éléments de classe "input"
        for( input of inputs ) { // Pour chaque élément de la collection,

            input.addEventListener( 'focus', function() { // On ajoute l'écouteur d'événement appliqué au déclencheur "focus"
                this.select();
            } );
        }

        document.querySelector( 'form' ).addEventListener( 'submit', function ( e ) {
            let acceptedValues= /^[\w\-.\+]+\+@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;

            if( document.getElementById( 'lastName' ).value == "" ) {
                alert( 'Veuilez renseignez votre nom.' );
            }
            if( document.getElementById( 'firstName' ).value == "" ) {
                alert( 'Veuilez renseignez votre nom.' );
            }
            if( document.getElementById( 'email' ).value == "" ) {
                alert( 'Veuilez renseignez votre email.' );
            } 
            if(!document.getElementById( 'email' ).value.match(acceptedValues)) {
                alert("structure d'adresse e-mail incorrecte");
                document.getElementById( 'email' ).focus();
            }
            if( document.getElementById( 'login' ).value == "" ) {
                alert( 'Veuilez renseignez votre pseudo.' );
            }
            if( document.getElementById( 'pwd' ).value == "" ) {
                alert( 'Veuilez renseignez votre mot de passe.' );
            }

            var xhr = getxhr();

            xhr.onreadystatechange = function () { //traite la requête dès que le flux est disponible
                if(xhr.readyState == 4 && xhr.status == 200){ // si la requête a aboutie
                    var jsonUser = JSON.parse(xhr.responseText);
                    console.log( jsonUser );
                } else {
                    console.log( 'status: ' + xhr.status );
                    document.getElementById( 'message' ).innerHTML += 'Code retour ' + xhr.status + ' : ' + xhr.statusText; // On affiche l'erreur
                }
            };

            if( this.getAttribute( 'method' ).toUpperCase()=='POST' ) {
                xhr.open( 'POST', this.getAttribute( 'action' ), true );// On initialise la requête
                var formDatas = new FormData( this ); // L'objet FormData récupère tous les champs du formulaire passé en paramêtre
                xhr.send( formDatas );// On envoie la requête
            } else {
                var datas = '';
                var inputs = this.querySelectorAll( 'input' );
                for( var i=0; i<inputs.length; i++ ) {
                    if( datas!='' ) datas += '&';
                    datas += inputs[i].name + '=' + inputs[i].value;
                }
                xhr.open( 'GET', this.getAttribute( 'action' ) + '?' + datas, true ); // On initialise la requête
                xhr.send( null ); // On envoie la requête
            }
            e.preventDefault();
        } );
    } );
        
//]]>