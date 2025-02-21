    document.addEventListener("DOMContentLoaded", function () {
        const tiposCuerpo = {
            "ectomorfo": { titulo: "Ectomorfo", descripcion: "Los ectomorfos tienen cuerpos delgados, metabolismo rápido y dificultad para ganar masa muscular." },
            "mesomorfo": { titulo: "Mesomorfo", descripcion: "Los mesomorfos tienen cuerpos atléticos, ganan músculo fácilmente y tienen un metabolismo equilibrado." },
            "endomorfo": { titulo: "Endomorfo", descripcion: "Los endomorfos tienen tendencia a ganar grasa, metabolismo lento y les cuesta definir su musculatura." }
        };
        document.querySelectorAll(".tipo-cuerpo").forEach(element => {
            element.addEventListener("click", function () {
                const id = this.id;
                document.getElementById("modalTitle").textContent = tiposCuerpo[id].titulo;
                document.getElementById("modalDescription").textContent = tiposCuerpo[id].descripcion;
                document.getElementById("modal").style.display = "block";
            });
        });
        document.querySelector(".close").addEventListener("click", function () {
            document.getElementById("modal").style.display = "none";
        });
    });