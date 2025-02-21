document.addEventListener("DOMContentLoaded", function () {
    const musculosSVG1 = ["triceps", "deltoides", "dorsal", "trapecio", "infraespinoso", "g278", "gluteos", "aductores", "isioquibiales", "g279", "soleo"];
    const musculosSVG2 = ["pectorales", "deltoides", "biceps", "braquiorradial", "recto_abdominal", "oblicuos", "cuadriceps", "aductores", "tibial"]; //g278 y g279 = gemelos y redondo mayor

    function manejarSVG(svgID, musculos) {
        const svgObject = document.getElementById(svgID);
        svgObject.addEventListener("load", function () {
            const svgDoc = svgObject.contentDocument;
            musculos.forEach(id => {
                let musculo = svgDoc.getElementById(id);
                if (musculo) {
                    musculo.style.cursor = "pointer";
                    musculo.addEventListener("mouseover", function () {
                        musculo.querySelectorAll("path").forEach(path => {
                            path.style.fill = "red";
                        });
                        mostrarTexto(id);
                    });
                    musculo.addEventListener("mouseout", function () {
                        musculo.querySelectorAll("path").forEach(path => {
                            path.style.fill = "black";
                        });
                        ocultarTexto();
                    });
                    musculo.addEventListener("click", function () {
                        window.location.href = `ejercicios/${id}.php`;
                    });
                } else {
                    console.warn(`⚠️ Músculo NO encontrado: ${id}`);
                }
            });
        });
    }

    manejarSVG("svgObject1", musculosSVG1);
    manejarSVG("svgObject2", musculosSVG2);
});