// Simuler une session utilisateur
let isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

// Fonction pour vérifier si l'utilisateur est connecté
function checkLogin() {
    if (!isLoggedIn && !window.location.pathname.includes("Connexion.html")) {
        window.location.href = "Connexion.html";
    }
}

// Fonction pour gérer la connexion
function handleLogin() {
    if (window.location.pathname.includes("Connexion.html")) {
        $('#login-form').submit(function (e) {
            e.preventDefault();
            const username = $('#username').val();
            const password = $('#password').val();

            // Simuler une vérification de connexion
            if (username === "admin" && password === "admin") {
                localStorage.setItem("isLoggedIn", "true");
                isLoggedIn = true;
                window.location.href = "Index.html";
            } else {
                alert("Nom d'utilisateur ou mot de passe incorrect.");
            }
        });
    }
}

// Fonction pour gérer la déconnexion
function handleLogout() {
    $('#logout-link').click(function (e) {
        e.preventDefault();
        localStorage.setItem("isLoggedIn", "false");
        isLoggedIn = false;
        window.location.href = "Connexion.html";
    });
}

// Fonction pour afficher les statistiques et le graphique historique
function displayStatistics() {
    if (window.location.pathname.includes("Statistiques.html")) {
        console.log("Affichage des statistiques...");

        // Données fictives pour les statistiques
        const statisticsData = [
            { sensor: "Température", average: "25.5°C", max: "40.0°C" },
            { sensor: "Pression", average: "5.5 bar", max: "10.0 bar" },
            { sensor: "Vibration", average: "50.0", max: "100.0" },
        ];

        const tableBody = document.getElementById("statistics-table");
        if (!tableBody) {
            console.error("Le tableau des statistiques n'a pas été trouvé.");
            return;
        }

        tableBody.innerHTML = ""; // Vider le tableau avant d'ajouter de nouvelles données

        statisticsData.forEach((data) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${data.sensor}</td>
                <td>${data.average}</td>
                <td>${data.max}</td>
            `;
            tableBody.appendChild(row);
        });

        console.log("Statistiques affichées avec succès.");

        // Données fictives pour le graphique historique
        const historicalData = {
            labels: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"],
            datasets: [
                {
                    label: 'Température (°C)',
                    data: [20, 22, 25, 28, 30, 32, 35, 34, 30, 27, 23, 20],
                    borderColor: 'rgba(0, 123, 255, 1)',
                    fill: false,
                },
                {
                    label: 'Pression (bar)',
                    data: [5, 6, 7, 8, 9, 10, 9, 8, 7, 6, 5, 4],
                    borderColor: 'rgba(40, 167, 69, 1)',
                    fill: false,
                },
                {
                    label: 'Vibration (unités)',
                    data: [50, 60, 70, 80, 90, 100, 90, 80, 70, 60, 50, 40],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    fill: false,
                },
            ],
        };

        // Initialiser le graphique historique
        const ctx = document.getElementById('historicalChart').getContext('2d');
        const historicalChart = new Chart(ctx, {
            type: 'line',
            data: historicalData,
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Mois',
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Valeurs',
                        },
                    },
                },
            },
        });
    }
}

// Fonction pour vérifier les seuils et afficher des alertes
function checkThresholds(data) {
    const temperature = parseFloat(data.temperature);
    const pressure = parseFloat(data.pressure);
    const vibration = parseFloat(data.vibration);

    // Réinitialiser les alertes
    $('#temperature-alert').hide();
    $('#pressure-alert').hide();
    $('#vibration-alert').hide();

    // Vérifier les seuils
    if (temperature > 35) {
        $('#temperature-alert').show().text(`Alerte : Température élevée (${temperature}°C)`);
        showNotification('Alerte Température', `Température élevée : ${temperature}°C`);
        addAlertToHistory(`Température élevée : ${temperature}°C`);
    }
    if (pressure > 8) {
        $('#pressure-alert').show().text(`Alerte : Pression élevée (${pressure} bar)`);
        showNotification('Alerte Pression', `Pression élevée : ${pressure} bar`);
        addAlertToHistory(`Pression élevée : ${pressure} bar`);
    }
    if (vibration > 80) {
        $('#vibration-alert').show().text(`Alerte : Vibration élevée (${vibration} unités)`);
        showNotification('Alerte Vibration', `Vibration élevée : ${vibration} unités`);
        addAlertToHistory(`Vibration élevée : ${vibration} unités`);
    }
}

// Fonction pour afficher des notifications
function showNotification(title, message) {
    if (Notification.permission === 'granted') {
        new Notification(title, { body: message });
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                new Notification(title, { body: message });
            }
        });
    }
}

// Fonction pour ajouter une alerte à l'historique
function addAlertToHistory(message) {
    const alertItem = `<li class="list-group-item">${message}</li>`;
    $('#alert-history').append(alertItem);
}

// Fonction pour mettre à jour les statistiques
function updateStatistics() {
    if (!chart) {
        console.error("Le graphique n'est pas initialisé.");
        return;
    }

    const temperatures = chart.data.datasets[0].data.map((item) => item.y);
    const pressures = chart.data.datasets[1].data.map((item) => item.y);
    const vibrations = chart.data.datasets[2].data.map((item) => item.y);

    const avgTemperature = temperatures.length > 0
        ? (temperatures.reduce((a, b) => a + b, 0) / temperatures.length).toFixed(2)
        : '--';
    const maxTemperature = temperatures.length > 0
        ? Math.max(...temperatures).toFixed(2)
        : '--';

    const avgPressure = pressures.length > 0
        ? (pressures.reduce((a, b) => a + b, 0) / pressures.length).toFixed(2)
        : '--';
    const maxPressure = pressures.length > 0
        ? Math.max(...pressures).toFixed(2)
        : '--';

    const avgVibration = vibrations.length > 0
        ? (vibrations.reduce((a, b) => a + b, 0) / vibrations.length).toFixed(2)
        : '--';
    const maxVibration = vibrations.length > 0
        ? Math.max(...vibrations).toFixed(2)
        : '--';

    $('#avgTemperature').text(avgTemperature);
    $('#maxTemperature').text(maxTemperature);
    $('#avgPressure').text(avgPressure);
    $('#maxPressure').text(maxPressure);
    $('#avgVibration').text(avgVibration);
    $('#maxVibration').text(maxVibration);
}

// Mettre à jour le dashboard toutes les secondes (si sur la page d'accueil)
if (window.location.pathname.includes("Index.html")) {
    const ctx = document.getElementById('sensorChart').getContext('2d');
    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Temps (timestamps)
            datasets: [
                {
                    label: 'Température (°C)',
                    data: [],
                    borderColor: 'rgba(0, 123, 255, 1)',
                    fill: false,
                },
                {
                    label: 'Pression (bar)',
                    data: [],
                    borderColor: 'rgba(40, 167, 69, 1)',
                    fill: false,
                },
                {
                    label: 'Vibration (unités)',
                    data: [],
                    borderColor: 'rgba(255, 193, 7, 1)',
                    fill: false,
                },
            ],
        },
        options: {
            animation: {
                duration: 1000, // Durée de l'animation en millisecondes
                easing: 'easeInOutQuad', // Type d'animation
            },
            scales: {
                x: {
                    type: 'time', // Utiliser une échelle de temps
                    time: {
                        unit: 'second', // Afficher les secondes
                        displayFormats: {
                            second: 'HH:mm:ss', // Format d'affichage
                        },
                    },
                    title: {
                        display: true,
                        text: 'Temps',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Valeurs',
                    },
                },
            },
        },
    });

    // Fonction pour générer des données aléatoires
    function generateSensorData() {
        return {
            temperature: (Math.random() * 20 + 20).toFixed(2), // Température entre 20°C et 40°C
            pressure: (Math.random() * 9 + 1).toFixed(2),     // Pression entre 1 et 10 bar
            vibration: (Math.random() * 100).toFixed(2),      // Vibration entre 0 et 100
            timestamp: new Date().toISOString(),              // Horodatage au format ISO
        };
    }

    setInterval(function () {
        const data = generateSensorData();
        console.log("Données générées :", data);

        // Mettre à jour les cartes
        $('#temperature').text(data.temperature);
        $('#pressure').text(data.pressure);
        $('#vibration').text(data.vibration);

        // Vérifier les seuils et afficher les alertes
        checkThresholds(data);

        // Mettre à jour le graphique
        chart.data.labels.push(data.timestamp);
        chart.data.datasets[0].data.push({ x: data.timestamp, y: parseFloat(data.temperature) });
        chart.data.datasets[1].data.push({ x: data.timestamp, y: parseFloat(data.pressure) });
        chart.data.datasets[2].data.push({ x: data.timestamp, y: parseFloat(data.vibration) });

        // Limiter le nombre de points affichés
        if (chart.data.labels.length > 50) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
            chart.data.datasets[1].data.shift();
            chart.data.datasets[2].data.shift();
        }

        chart.update();
        updateStatistics();
    }, 1000);
}

// Appeler les fonctions spécifiques à chaque page
checkLogin();
handleLogin();
handleLogout();
displayStatistics(); // Ajout de l'appel pour afficher les statistiques