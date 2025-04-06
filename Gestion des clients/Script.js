$(document).ready(function () {
    // ==============================================
    // Tableaux globaux pour stocker les données
    // ==============================================
    let clients = JSON.parse(localStorage.getItem('clients')) || [];
    let livres = JSON.parse(localStorage.getItem('livres')) || [];
    let panier = JSON.parse(localStorage.getItem('panier')) || [];
    let employes = JSON.parse(localStorage.getItem('employes')) || [];
    let historique = JSON.parse(localStorage.getItem('historique')) || [];

    // ==============================================
    // Fonctions utilitaires pour sauvegarder les données
    // ==============================================
    function saveClients() {
        localStorage.setItem('clients', JSON.stringify(clients));
    }

    function saveLivres() {
        localStorage.setItem('livres', JSON.stringify(livres));
    }

    function savePanier() {
        localStorage.setItem('panier', JSON.stringify(panier));
    }

    function saveEmployes() {
        localStorage.setItem('employes', JSON.stringify(employes));
    }

    function saveHistorique() {
        localStorage.setItem('historique', JSON.stringify(historique));
    }

    // ==============================================
    // Gestion de la Connexion
    // ==============================================
    $('#loginForm').submit(function (event) {
        event.preventDefault();
        const username = $('#username').val();
        const password = $('#password').val();

        // Simuler une connexion réussie
        if (username === "admin" && password === "admin123") {
            window.location.href = "Admin.html";
        } else if (username === "employe" && password === "employe123") {
            window.location.href = "Clients.html";
        } else {
            alert("Nom d'utilisateur ou mot de passe incorrect");
        }
    });

    // ==============================================
    // Gestion de la Déconnexion
    // ==============================================
    $('#logoutButton').click(function (event) {
        event.preventDefault();
        window.location.href = "Index.html";
    });

    // ==============================================
    // Gestion des Clients
    // ==============================================
    function displayClients() {
        $('#clientTable').empty();
        clients.forEach((client, index) => {
            $('#clientTable').append(`
                <tr>
                    <td>${client.nom}</td>
                    <td>${client.email}</td>
                    <td>${client.telephone}</td>
                    <td>${client.genre}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editClient(${index})">Modifier</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteClient(${index})">Supprimer</button>
                    </td>
                </tr>
            `);
        });
    }

    window.editClient = function (index) {
        const client = clients[index];
        $('#clientId').val(index);
        $('#nom').val(client.nom);
        $('#email').val(client.email);
        $('#telephone').val(client.telephone);
        $('#genre').val(client.genre);
        $('#submitButton').text('Mettre à jour');
    };

    $('#clientForm').submit(function (event) {
        event.preventDefault();
        const index = $('#clientId').val();
        const client = {
            nom: $('#nom').val(),
            email: $('#email').val(),
            telephone: $('#telephone').val(),
            genre: $('#genre').val()
        };

        if (index !== "") {
            clients[index] = client; // Mettre à jour le client existant
        } else {
            clients.push(client); // Ajouter un nouveau client
        }

        saveClients();
        displayClients();
        $('#clientForm')[0].reset();
        $('#submitButton').text('Ajouter un client');
        $('#clientId').val("");
    });

    window.deleteClient = function (index) {
        clients.splice(index, 1);
        saveClients();
        displayClients();
    };

    // ==============================================
    // Gestion des Livres
    // ==============================================
    function displayLivres() {
        $('#bookTable').empty();
        livres.forEach((livre, index) => {
            $('#bookTable').append(`
                <tr>
                    <td>${livre.titre}</td>
                    <td>${livre.auteur}</td>
                    <td>${livre.genre}</td>
                    <td>${livre.prix} €</td>
                    <td>${livre.quantite}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editLivre(${index})">Modifier</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteLivre(${index})">Supprimer</button>
                    </td>
                </tr>
            `);
        });
    }

    window.editLivre = function (index) {
        const livre = livres[index];
        $('#bookId').val(index);
        $('#titre').val(livre.titre);
        $('#auteur').val(livre.auteur);
        $('#genreLivre').val(livre.genre);
        $('#prix').val(livre.prix);
        $('#quantite').val(livre.quantite);
        $('#submitBookButton').text('Mettre à jour');
    };

    $('#bookForm').submit(function (event) {
        event.preventDefault();
        const index = $('#bookId').val();
        const livre = {
            titre: $('#titre').val(),
            auteur: $('#auteur').val(),
            genre: $('#genreLivre').val(),
            prix: $('#prix').val(),
            quantite: $('#quantite').val()
        };

        if (index !== "") {
            livres[index] = livre; // Mettre à jour le livre existant
        } else {
            livres.push(livre); // Ajouter un nouveau livre
        }

        saveLivres();
        displayLivres();
        $('#bookForm')[0].reset();
        $('#submitBookButton').text('Ajouter un livre');
        $('#bookId').val("");
    });

    window.deleteLivre = function (index) {
        livres.splice(index, 1);
        saveLivres();
        displayLivres();
    };

    // ==============================================
    // Gestion du Panier
    // ==============================================
    function updateClientSelect() {
        $('#clientSelect').empty();
        clients.forEach((client) => {
            $('#clientSelect').append(`<option value="${client.nom}">${client.nom}</option>`);
        });
    }

    function updateLivreSelect() {
        $('#livreSelect').empty();
        livres.forEach((livre) => {
            $('#livreSelect').append(`<option value="${livre.titre}">${livre.titre}</option>`);
        });
    }

    function displayPanier() {
        $('#cartList').empty();
        let total = 0;
        panier.forEach((article, index) => {
            $('#cartList').append(`
                <li class="list-group-item">
                    ${article.titre} - ${article.prix} € x ${article.quantite}
                    <button class="btn btn-danger btn-sm float-end" onclick="deleteFromCart(${index})">Supprimer</button>
                </li>
            `);
            total += article.prix * article.quantite;
        });
        $('#totalAmount').text(total.toFixed(2));
    }

    $('#addToCartButton').click(function () {
        const livreTitre = $('#livreSelect').val();
        const quantite = parseInt($('#quantite').val());
        const livre = livres.find((l) => l.titre === livreTitre);

        if (livre && quantite > 0) {
            panier.push({
                titre: livre.titre,
                prix: livre.prix,
                quantite: quantite
            });
            savePanier();
            displayPanier();
        } else {
            alert("Veuillez sélectionner un livre et une quantité valide.");
        }
    });

    window.deleteFromCart = function (index) {
        panier.splice(index, 1);
        savePanier();
        displayPanier();
    };

    $('#checkoutButton').click(function () {
        const clientNom = $('#clientSelect').val();
        if (panier.length === 0) {
            alert("Le panier est vide.");
            return;
        }

        const achat = {
            date: new Date().toLocaleDateString(),
            client: clientNom,
            articles: panier,
            total: parseFloat($('#totalAmount').text())
        };
        historique.push(achat);
        saveHistorique();

        panier = [];
        savePanier();
        displayPanier();

        alert("Achat validé !");
    });

    // ==============================================
    // Gestion des Employés
    // ==============================================
    function displayEmployes() {
        $('#employeeTable').empty();
        employes.forEach((employe, index) => {
            $('#employeeTable').append(`
                <tr>
                    <td>${employe.nom}</td>
                    <td>${employe.username}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editEmploye(${index})">Modifier</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteEmploye(${index})">Supprimer</button>
                    </td>
                </tr>
            `);
        });
    }

    window.editEmploye = function (index) {
        const employe = employes[index];
        $('#employeeName').val(employe.nom);
        $('#employeeUsername').val(employe.username);
        $('#employeePassword').val(employe.password);
        $('#employeeForm button[type="submit"]').text('Mettre à jour');
        $('#employeeForm').data('index', index);
    };

    $('#employeeForm').submit(function (event) {
        event.preventDefault();
        const index = $(this).data('index');
        const employe = {
            nom: $('#employeeName').val(),
            username: $('#employeeUsername').val(),
            password: $('#employeePassword').val()
        };

        if (index !== undefined) {
            employes[index] = employe; // Mettre à jour l'employé existant
        } else {
            employes.push(employe); // Ajouter un nouvel employé
        }

        saveEmployes();
        displayEmployes();
        $('#employeeForm')[0].reset();
        $('#employeeForm button[type="submit"]').text('Créer un compte employé');
        $('#employeeForm').removeData('index');
    });

    window.deleteEmploye = function (index) {
        employes.splice(index, 1);
        saveEmployes();
        displayEmployes();
    };

    // ==============================================
    // Gestion de l'Historique des Achats
    // ==============================================
    function displayHistorique() {
        $('#historiqueTable').empty();
        historique.forEach((achat) => {
            achat.articles.forEach((article) => {
                $('#historiqueTable').append(`
                    <tr>
                        <td>${achat.date}</td>
                        <td>${achat.client}</td>
                        <td>${article.titre}</td>
                        <td>${article.quantite}</td>
                        <td>${article.prix * article.quantite} €</td>
                    </tr>
                `);
            });
        });
    }

    // ==============================================
    // Initialisation
    // ==============================================
    displayClients();
    displayLivres();
    updateClientSelect();
    updateLivreSelect(); // Mettre à jour la liste des livres dans le panier
    displayPanier();
    displayEmployes();
    displayHistorique();
});