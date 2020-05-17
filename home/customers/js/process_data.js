var depot = document.getElementById("depot");
var nomsFichier = document.getElementById("noms_fichiers");

var str_datas = "";
var customers = [];
var loading = false;
var name_source = $("#name_source").val();

depot.ondragover = function(event){
    event.stopPropagation();
    event.preventDefault();
    depot.style.backgroundColor = "#8E166C";
}

depot.ondrop = function(event){
    event.stopPropagation();
    event.preventDefault();
    depot.style.backgroundColor = "#FFAAAA";
    var fichiers = event.dataTransfer.files;
    var resultats = [];
    var fichierCsv = fichiers[0];
    
    resultats.push("<li><strong>" + escape(fichierCsv.name) + "</strong> - " + fichierCsv.size + " octets </li>");
    var reader = new FileReader();
    reader.onload = function(e){
        str_datas = e.target.result;
        var raw_customers = str_datas.split("\n");

        raw_customers.forEach(function(raw_lead) {
            customers.push(raw_lead.split(";"));
        })
    }

    reader.onloadend = function() {
        if (customers.length > 1) {
            $.ajax({
                method: "POST",
                url: "./ajax/csv2bdd.php",
                data: {
                    customers: JSON.stringify(customers),
                    name_source: name_source
                },
                beforeSend: function() {
                    $("#loader").show();
                },
                success: function(data) {
                    $("#loader").hide();
                }
            })
            .done(function(result) {
                $("#line_process").append(result);
            })
            .fail(function(message) {
                console.log("Erreur ajax  : ", message);
            });
        } else {
            console.log("Erreur de données - Nombre de lignes : ", customers.length);
        }
    }

    reader.readAsText(fichierCsv,"UTF-8");

    // On ajoute sur la page des informations sur le fichiers
    nomsFichier.innerHTML = "<ul>" + resultats.join('') + "</ul>";
}