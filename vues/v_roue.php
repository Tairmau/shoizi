<div class="container-roue">
    <div class="left">
        <div id="wheel-container">
            <canvas id="wheel" width="500" height="500"></canvas>
            <div id="spin">GO !</div>
            <!--<div id="result"></div>-->
        </div>
    </div>
    <div class="right">
        <h2 id="maxchoix">Ajoute un choix</h2>
        <div class="middle">
            <input type="text" placeholder="Choix numéro X" id="inputchoix">
            <button type="submit" id="enregistrer">Enregistrer</button>
        </div>
        <div class="bottom">
            <a href="https://github.com/Tairmau" class="liens" target="_blank"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-github"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                Github
            </a>
            <a href="https://www.linkedin.com/in/francis-siber-50635425a/" target="_blank" class="liens"> 
                <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#ffffff" d="M12.225 12.225h-1.778V9.44c0-.664-.012-1.519-.925-1.519-.926 0-1.068.724-1.068 1.47v2.834H6.676V6.498h1.707v.783h.024c.348-.594.996-.95 1.684-.925 1.802 0 2.135 1.185 2.135 2.728l-.001 3.14zM4.67 5.715a1.037 1.037 0 01-1.032-1.031c0-.566.466-1.032 1.032-1.032.566 0 1.031.466 1.032 1.032 0 .566-.466 1.032-1.032 1.032zm.889 6.51h-1.78V6.498h1.78v5.727zM13.11 2H2.885A.88.88 0 002 2.866v10.268a.88.88 0 00.885.866h10.226a.882.882 0 00.889-.866V2.865a.88.88 0 00-.889-.864z"></path></g></svg>
                LinkedIn 
            </a>
        </div>
    </div>
</div>
<script>
        document.addEventListener("DOMContentLoaded", function () {
            let label = document.getElementById('inputchoix');
            let enregistrer = document.getElementById('enregistrer');
            let maxchoixTxt = document.getElementById('maxchoix');
            let prizes = [];
            let currentRotation = 0;


            function ajoutChoix(label, color) {         
                if(prizes.length < 8){
                    prizes.push({ label: label, color: color });
                    drawWheel();
                }else{
                    alert('Nombre de choix maximum atteint');
                    label.disabled = true;
                    enregistrer.disabled = true;
                    enregistrer.style.backgroundColor = "grey";
                    maxchoixTxt.innerHTML = "Nombre Maximum de choix atteint !"
                    maxchoixTxt.style.color = "red";
                }       
            }
            function drawWheel() {
                const canvas = document.getElementById('wheel');
                const ctx = canvas.getContext('2d');
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;
                const radius = canvas.width / 2;
                const anglePerSegment = (2 * Math.PI) / prizes.length;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                prizes.forEach((prize, index) => {
                    const startAngle = index * anglePerSegment + currentRotation;
                    const endAngle = startAngle + anglePerSegment;

                    ctx.beginPath();
                    ctx.moveTo(centerX, centerY);
                    ctx.arc(centerX, centerY, radius, startAngle, endAngle);
                    ctx.fillStyle = prize.color;
                    ctx.fill();
                    ctx.stroke();
                    ctx.save();
                    ctx.translate(centerX, centerY);
                    ctx.rotate((startAngle + endAngle) / 2);
                    ctx.textAlign = 'right';
                    ctx.fillStyle = '#000';
                    ctx.font = '16px Arial';
                    ctx.fillText(prize.label, radius - 10, 10);
                    ctx.restore();
                });
            }

            function rotateWheel() {
                if(prizes.length > 1){
                    const spinTime = 2000;
                    const fullRotations = 5;
                    const stopAngle = Math.random() * Math.PI * 2;
                    let startTime = null;

                    function rotate(timestamp) {
                        if (!startTime) startTime = timestamp;
                        const runtime = timestamp - startTime;
                        const progress = runtime / spinTime;
                        const angle = progress * fullRotations * Math.PI * 2 + stopAngle;

                        currentRotation = angle % (Math.PI * 2);
                        drawWheel();
                        if (runtime < spinTime) {
                            requestAnimationFrame(rotate);
                        } else {
                            const prizeAngle = (Math.PI * 2) / prizes.length;
                            const selectedPrizeIndex = Math.floor((currentRotation + prizeAngle / 2) / prizeAngle) % prizes.length;
                            alert("Résultat: " + prizes[selectedPrizeIndex].label);
                            prizes.splice(selectedPrizeIndex, 1);
                            drawWheel();
                            label.disabled = false;
                            enregistrer.disabled = false;
                            enregistrer.style.backgroundColor = "#03045e";
                            maxchoixTxt.innerHTML = "Ajoute un choix !"
                            maxchoixTxt.style.color = "black";
                        }
                    }

                    requestAnimationFrame(rotate);
                }else{
                    alert("Il faut d'abbord ajouter 2 choix minimum");
                }

            }

            enregistrer.addEventListener('click', () => {

                if (label.value != "" ) {
                    let colors = ["#ffbe0b", "#fb5607", "#ff006e", "#8338ec", "#3a86ff", "#2a9d8f", "#9e2a2b","#ff70a6"];
                    //const color = "#95a5a6";
                    let colorIndex = prizes.length % colors.length;
                    ajoutChoix(label.value, colors[colorIndex]);
                    //let randomColor = colors[Math.floor(Math.random() * colors.length)];
                    ajoutChoix(label.value, randomColor);

                    label.value = "";

                } else {
                    alert('Veuillez rentrer un choix valide');
                }
            });

            document.getElementById("spin").addEventListener("click", rotateWheel);
            drawWheel();
        });
</script>