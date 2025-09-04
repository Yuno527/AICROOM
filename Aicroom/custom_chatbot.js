// Chatbot personalizado para AICROOM
class CustomChatbot {
    constructor() {
        this.currentQuestion = 0;
        this.answers = [];
        this.totalScore = 0;
        this.isCompleted = false;
        this.userId = null;
        
        // Banco de 20 preguntas con sus opciones y puntajes
        this.allQuestions = [
            {
                question: "Cuando un proyecto grupal no avanza por falta de liderazgo, ¿cómo actúas?",
                options: [
                    { text: "Espero que alguien más tome la iniciativa.", score: 1 },
                    { text: "Propongo algunas ideas, pero sin involucrarme mucho.", score: 2 },
                    { text: "Asumo un rol activo y organizo al grupo para avanzar.", score: 3 }
                ]
            },
            {
                question: "Si te asignan una tarea fuera de tu zona de confort, ¿qué haces?",
                options: [
                    { text: "Me frustro y evito enfrentarla.", score: 1 },
                    { text: "Pido ayuda y trato de aprender lo necesario.", score: 2 },
                    { text: "Me esfuerzo por aprender rápidamente y cumplir.", score: 3 }
                ]
            },
            {
                question: "¿Cómo respondes ante un compañero que desacredita tu opinión frente a otros?",
                options: [
                    { text: "Me callo y evito conflictos.", score: 1 },
                    { text: "Hablo con él en privado para aclarar.", score: 2 },
                    { text: "Mantengo la calma y defiendo mi punto con respeto.", score: 3 }
                ]
            },
            {
                question: "¿Qué haces si ves a tu equipo tomando una decisión errada por presión del tiempo?",
                options: [
                    { text: "Me limito a seguir el ritmo del grupo.", score: 1 },
                    { text: "Expreso mi preocupación, pero dejo que decidan.", score: 2 },
                    { text: "Detengo el proceso para analizar riesgos y proponer alternativas.", score: 3 }
                ]
            },
            {
                question: "¿Cómo te enfrentas a un error grave que cometiste en un proyecto importante?",
                options: [
                    { text: "Intento ocultarlo para evitar consecuencias.", score: 1 },
                    { text: "Informo del error y busco minimizar el impacto.", score: 2 },
                    { text: "Asumo la responsabilidad y colaboro en una solución inmediata.", score: 3 }
                ]
            },
            {
                question: "¿Cómo manejas una reunión en la que nadie colabora ni aporta ideas?",
                options: [
                    { text: "Permanezco callado esperando que pase.", score: 1 },
                    { text: "Trato de animar al grupo, pero sin insistir.", score: 2 },
                    { text: "Propongo dinámicas o preguntas para activar la participación.", score: 3 }
                ]
            },
            {
                question: "Si un cliente o usuario te habla con tono agresivo, ¿cómo respondes?",
                options: [
                    { text: "Respondo de la misma forma.", score: 1 },
                    { text: "Escucho, pero me pongo a la defensiva.", score: 2 },
                    { text: "Mantengo la calma, escucho y busco entender.", score: 3 }
                ]
            },
            {
                question: "¿Cómo organizas tu trabajo cuando tienes varios proyectos con fechas similares?",
                options: [
                    { text: "Empiezo por el que más me gusta y avanzo sin orden.", score: 1 },
                    { text: "Hago lo que se me ocurre primero y resuelvo en el camino.", score: 2 },
                    { text: "Prioritizo, divido tareas y asigno tiempos.", score: 3 }
                ]
            },
            {
                question: "¿Cómo manejas situaciones donde hay tensión o rivalidad entre compañeros?",
                options: [
                    { text: "Me mantengo alejado y no me involucro.", score: 1 },
                    { text: "Intento mediar, pero si no funciona, me retiro.", score: 2 },
                    { text: "Escucho a ambas partes y promuevo una conversación constructiva.", score: 3 }
                ]
            },
            {
                question: "Si te piden entregar algo urgente que compromete la calidad del trabajo, ¿qué haces?",
                options: [
                    { text: "Entrego lo más rápido posible, aunque no quede bien.", score: 1 },
                    { text: "Intento equilibrar velocidad y calidad como pueda.", score: 2 },
                    { text: "Comunico las limitaciones y propongo una solución viable.", score: 3 }
                ]
            },
            {
                question: "¿Cómo manejas tus emociones cuando recibes una crítica inesperada?",
                options: [
                    { text: "Me bloqueo y me molesta mucho.", score: 1 },
                    { text: "Me incomoda, pero reflexiono sobre lo que dijeron.", score: 2 },
                    { text: "Escucho con atención y uso la crítica para mejorar.", score: 3 }
                ]
            },
            {
                question: "¿Qué haces si tu equipo no cumple con su parte y afecta tu trabajo?",
                options: [
                    { text: "Me molesto pero no digo nada.", score: 1 },
                    { text: "Hago su parte para no quedar mal.", score: 2 },
                    { text: "Hablo con el equipo para corregir el rumbo juntos.", score: 3 }
                ]
            },
            {
                question: "¿Cómo te comportas en ambientes con alta presión o muchos cambios?",
                options: [
                    { text: "Me frustro y bajo mi rendimiento.", score: 1 },
                    { text: "Me adapto, aunque me cueste.", score: 2 },
                    { text: "Me ajusto rápido y busco soluciones prácticas.", score: 3 }
                ]
            },
            {
                question: "¿Cómo manejas una situación en la que necesitas delegar parte de tu trabajo?",
                options: [
                    { text: "Prefiero hacerlo todo yo mismo.", score: 1 },
                    { text: "Delego, pero reviso todo luego.", score: 2 },
                    { text: "Confío en el equipo y doy seguimiento oportuno.", score: 3 }
                ]
            },
            {
                question: "¿Qué haces si recibes tareas repetitivas que te desmotivan?",
                options: [
                    { text: "Las hago sin ganas.", score: 1 },
                    { text: "Trato de cambiar de tarea cuando puedo.", score: 2 },
                    { text: "Busco formas de mejorar el proceso o motivarme.", score: 3 }
                ]
            },
            {
                question: "¿Cómo te comportas en situaciones que requieren trabajo con personas muy distintas a ti?",
                options: [
                    { text: "Evito relacionarme mucho.", score: 1 },
                    { text: "Me adapto poco a poco.", score: 2 },
                    { text: "Acepto la diversidad y la veo como una oportunidad.", score: 3 }
                ]
            },
            {
                question: "¿Qué haces cuando un compañero está pasando por una situación personal difícil?",
                options: [
                    { text: "Me mantengo al margen.", score: 1 },
                    { text: "Le ofrezco ayuda solo si me habla.", score: 2 },
                    { text: "Me acerco, escucho y me muestro disponible.", score: 3 }
                ]
            },
            {
                question: "¿Cómo actúas cuando tienes que aprender una nueva habilidad en poco tiempo?",
                options: [
                    { text: "Me angustio y evito comenzar.", score: 1 },
                    { text: "Busco ayuda y estudio cuando puedo.", score: 2 },
                    { text: "Me organizo, estudio y practico intensamente.", score: 3 }
                ]
            },
            {
                question: "¿Qué haces si debes trabajar con alguien con quien has tenido conflictos antes?",
                options: [
                    { text: "Hago lo mínimo necesario para evitarlo.", score: 1 },
                    { text: "Trato de mantener respeto y distancia.", score: 2 },
                    { text: "Busco reconstruir la relación y colaborar profesionalmente.", score: 3 }
                ]
            },
            {
                question: "¿Cómo reaccionas ante un cambio de planes en el último minuto?",
                options: [
                    { text: "Me frustro y me cuesta adaptarme.", score: 1 },
                    { text: "Me acomodo como puedo, aunque no me guste.", score: 2 },
                    { text: "Acepto el cambio y reajusto mis planes con rapidez.", score: 3 }
                ]
            }
        ];
        // Seleccionar 10 preguntas aleatorias para esta sesión
        this.questions = this.shuffleArray([...this.allQuestions]).slice(0, 10);
        
        this.init();
    }
    
    init() {
        this.checkUserStatus();
        this.createChatbotInterface();
        this.showWelcomeMessage();
    }
    
    // Verificar si el usuario está logueado y si ya completó el test
    async checkUserStatus() {
        try {
            const response = await fetch('get_user_status.php');
            const data = await response.json();
            
            if (data.logged_in) {
                this.userId = data.user_id;
                this.userEmail = data.user_email;
                this.userName = data.user_name;
                
                // Verificar si ya completó el test
                const testResponse = await fetch('check_test_completion.php');
                const testData = await testResponse.json();
                
                if (testData.completed) {
                    this.showAlreadyCompletedMessage();
                }
            } else {
                this.showLoginRequiredMessage();
            }
        } catch (error) {
            console.error('Error verificando estado del usuario:', error);
            this.showLoginRequiredMessage();
        }
    }
    
    // Crear la interfaz del chatbot
    createChatbotInterface() {
        const chatbotContainer = document.createElement('div');
        chatbotContainer.id = 'custom-chatbot';
        chatbotContainer.innerHTML = `
            <div class="chatbot-header">
                <div class="chatbot-title">
                    <i class="fas fa-robot"></i>
                    <span>Evaluación de Habilidades Blandas</span>
                </div>
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="progressFill"></div>
                    </div>
                    <div class="question-counter" id="questionCounter">0/20</div>
                </div>
            </div>
            
            <div class="chatbot-content">
                <div class="welcome-message" id="welcomeMessage">
                    <div class="message-content">
                        <h3>👋 ¡Hola! Bienvenido/a a tu evaluación de habilidades blandas.</h3>
                        <p>🧠 Esta prueba consta de 20 preguntas diseñadas para conocer cómo enfrentas situaciones reales en tu entorno laboral o académico.</p>
                        <p>✅ Responde con sinceridad. No hay respuestas correctas o incorrectas, cada respuesta refleja tu estilo personal.</p>
                        <p>⏱️ El test tomará solo unos minutos.</p>
                        <p>Haz clic en las opciones que más se adapten a ti.</p>
                        <p>Cuando estés listo/a, haz clic en "Comenzar" para empezar.</p>
                        <p>¡Éxitos! 🌟</p>
                        <button class="start-btn" onclick="chatbot.startTest()">
                            <i class="fas fa-play"></i> Comenzar
                        </button>
                    </div>
                </div>
                
                <div class="question-container" id="questionContainer" style="display: none;">
                    <div class="timer" id="timer" style="font-weight:bold;color:#667eea;margin-bottom:10px;"></div>
                    <div class="question-text" id="questionText"></div>
                    <div class="options-container" id="optionsContainer"></div>
                </div>
                
                <div class="completion-message" id="completionMessage" style="display: none;">
                    <div class="message-content">
                        <h3>✅ ¡Gracias por completar la prueba!</h3>
                        <p>Tus respuestas han sido registradas exitosamente.</p>
                        <p>Nuestro equipo las revisará y las tendrá en cuenta para los procesos correspondientes.</p>
                        <p>🔒 Recuerda que toda la información proporcionada será tratada con confidencialidad.</p>
                        <p>Puedes cerrar esta ventana.</p>
                        <p>¡Te deseamos muchos éxitos! 🌟</p>
                        <button class="close-btn" onclick="chatbot.closeChatbot()">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
                
                <div class="login-required" id="loginRequired" style="display: none;">
                    <div class="message-content">
                        <h3>🔐 Acceso Requerido</h3>
                        <p>Para realizar la evaluación de habilidades blandas, necesitas iniciar sesión.</p>
                        <a href="login.html" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                        </a>
                    </div>
                </div>
                
                <div class="already-completed" id="alreadyCompleted" style="display: none;">
                    <div class="message-content">
                        <h3>📝 Evaluación Completada</h3>
                        <p>Ya has completado la evaluación de habilidades blandas.</p>
                        <p>Gracias por tu participación.</p>
                        <button class="close-btn" onclick="chatbot.closeChatbot()">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(chatbotContainer);
        
        // Agregar estilos CSS
        this.addStyles();
    }
    
    // Agregar estilos CSS
    addStyles() {
        const style = document.createElement('style');
        style.textContent = `
            #custom-chatbot {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 450px;
                height: 650px;
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0,0,0,0.15);
                z-index: 1000;
                display: flex;
                flex-direction: column;
                overflow: hidden;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                border: 1px solid rgba(102, 126, 234, 0.1);
            }
            
            .chatbot-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: relative;
                overflow: hidden;
            }
            
            .chatbot-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                opacity: 0.3;
            }
            
            .chatbot-title {
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 700;
                font-size: 1.1em;
                position: relative;
                z-index: 1;
            }
            
            .chatbot-title i {
                font-size: 1.3em;
                animation: pulse 2s infinite;
            }
            
            .progress-container {
                display: flex;
                align-items: center;
                gap: 15px;
                flex: 1;
                margin: 0 20px;
                position: relative;
                z-index: 1;
            }
            
            .progress-bar {
                flex: 1;
                height: 8px;
                background: rgba(255,255,255,0.2);
                border-radius: 4px;
                overflow: hidden;
                position: relative;
            }
            
            .progress-fill {
                height: 100%;
                background: linear-gradient(90deg, #fff, #f0f8ff);
                width: 0%;
                transition: width 0.5s ease;
                border-radius: 4px;
                position: relative;
            }
            
            .progress-fill::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                animation: shimmer 2s infinite;
            }
            
            .question-counter {
                font-size: 13px;
                font-weight: 600;
                background: rgba(255,255,255,0.2);
                padding: 4px 12px;
                border-radius: 15px;
                white-space: nowrap;
            }
            
            .chatbot-content {
                flex: 1;
                padding: 25px;
                overflow-y: auto;
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            }
            
            .chatbot-content::-webkit-scrollbar {
                width: 6px;
            }
            
            .chatbot-content::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 3px;
            }
            
            .chatbot-content::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 3px;
            }
            
            .chatbot-content::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }
            
            .message-content {
                text-align: center;
                padding: 20px 0;
            }
            
            .message-content h3 {
                color: #2c3e50;
                margin-bottom: 20px;
                font-size: 1.4em;
                font-weight: 700;
            }
            
            .message-content p {
                color: #5a6c7d;
                margin-bottom: 15px;
                line-height: 1.6;
                font-size: 1em;
            }
            
            .start-btn, .login-btn, .close-btn {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 30px;
                cursor: pointer;
                font-size: 15px;
                font-weight: 600;
                margin-top: 25px;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
                position: relative;
                overflow: hidden;
            }
            
            .start-btn::before, .login-btn::before, .close-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
                transition: left 0.5s;
            }
            
            .start-btn:hover::before, .login-btn:hover::before, .close-btn:hover::before {
                left: 100%;
            }
            
            .start-btn:hover, .login-btn:hover, .close-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            }
            
            .question-text {
                font-size: 17px;
                font-weight: 600;
                color: #2c3e50;
                margin-bottom: 25px;
                line-height: 1.5;
                padding: 20px;
                background: white;
                border-radius: 15px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                border-left: 4px solid #667eea;
            }
            
            .options-container {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }
            
            .option-btn {
                background: white;
                border: 2px solid #e9ecef;
                padding: 18px 20px;
                border-radius: 12px;
                cursor: pointer;
                text-align: left;
                transition: all 0.3s ease;
                font-size: 15px;
                line-height: 1.5;
                position: relative;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
            
            .option-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: #667eea;
                transform: scaleY(0);
                transition: transform 0.3s ease;
            }
            
            .option-btn:hover {
                border-color: #667eea;
                background: #f8f9ff;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
            }
            
            .option-btn:hover::before {
                transform: scaleY(1);
            }
            
            .option-btn.selected {
                border-color: #667eea;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            }
            
            .option-btn.selected::before {
                transform: scaleY(1);
                background: white;
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }
            
            @keyframes shimmer {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
            
            @media (max-width: 768px) {
                #custom-chatbot {
                    width: calc(100vw - 40px);
                    height: 600px;
                    bottom: 10px;
                    right: 20px;
                    border-radius: 15px;
                }
                
                .chatbot-header {
                    padding: 15px;
                }
                
                .chatbot-content {
                    padding: 20px;
                }
                
                .question-text {
                    font-size: 16px;
                    padding: 15px;
                }
                
                .option-btn {
                    padding: 15px 18px;
                    font-size: 14px;
                }
            }
        `;
        document.head.appendChild(style);
    }
    
    // Mostrar mensaje de bienvenida
    showWelcomeMessage() {
        document.getElementById('welcomeMessage').style.display = 'block';
        document.getElementById('questionContainer').style.display = 'none';
        document.getElementById('completionMessage').style.display = 'none';
        document.getElementById('loginRequired').style.display = 'none';
        document.getElementById('alreadyCompleted').style.display = 'none';
    }
    
    // Mostrar mensaje de login requerido
    showLoginRequiredMessage() {
        document.getElementById('welcomeMessage').style.display = 'none';
        document.getElementById('questionContainer').style.display = 'none';
        document.getElementById('completionMessage').style.display = 'none';
        document.getElementById('loginRequired').style.display = 'block';
        document.getElementById('alreadyCompleted').style.display = 'none';
    }
    
    // Mostrar mensaje de ya completado
    showAlreadyCompletedMessage() {
        document.getElementById('welcomeMessage').style.display = 'none';
        document.getElementById('questionContainer').style.display = 'none';
        document.getElementById('completionMessage').style.display = 'none';
        document.getElementById('loginRequired').style.display = 'none';
        document.getElementById('alreadyCompleted').style.display = 'block';
    }
    
    // Iniciar el test
    startTest() {
        document.getElementById('welcomeMessage').style.display = 'none';
        document.getElementById('questionContainer').style.display = 'block';
        this.showQuestion();
    }
    
    // Mostrar pregunta actual
    showQuestion() {
        if (this.currentQuestion >= this.questions.length) {
            this.completeTest();
            return;
        }
        // Limpiar cualquier temporizador anterior
        if (this.timerInterval) clearInterval(this.timerInterval);
        this.timeLeft = 20;
        document.getElementById('timer').textContent = `⏰ Tiempo restante: ${this.timeLeft}s`;
        this.timerInterval = setInterval(() => {
            this.timeLeft--;
            document.getElementById('timer').textContent = `⏰ Tiempo restante: ${this.timeLeft}s`;
            if (this.timeLeft <= 0) {
                clearInterval(this.timerInterval);
                this.selectOption({text: 'Sin respuesta', score: 0, timeout: true});
            }
        }, 1000);
        
        const question = this.questions[this.currentQuestion];
        document.getElementById('questionText').textContent = question.question;
        
        // Randomizar las opciones
        const shuffledOptions = this.shuffleArray([...question.options]);
        
        const optionsContainer = document.getElementById('optionsContainer');
        optionsContainer.innerHTML = '';
        
        shuffledOptions.forEach((option, index) => {
            const button = document.createElement('button');
            button.className = 'option-btn';
            button.textContent = option.text;
            button.onclick = () => this.selectOption(option);
            optionsContainer.appendChild(button);
        });
        
        // Actualizar progreso
        this.updateProgress();
    }
    
    // Randomizar array
    shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }
    
    // Seleccionar opción
    selectOption(option) {
        if (this.timerInterval) clearInterval(this.timerInterval);
        // Guardar respuesta
        this.answers.push({
            question: this.questions[this.currentQuestion].question,
            answer: option.text,
            score: option.score
        });
        
        this.totalScore += option.score;
        this.currentQuestion++;
        
        // Mostrar siguiente pregunta
        setTimeout(() => {
            this.showQuestion();
        }, 300);
    }
    
    // Actualizar barra de progreso
    updateProgress() {
        const progress = (this.currentQuestion / this.questions.length) * 100;
        document.getElementById('progressFill').style.width = progress + '%';
        document.getElementById('questionCounter').textContent = `${this.currentQuestion}/${this.questions.length}`;
    }
    
    // Completar test
    async completeTest() {
        this.isCompleted = true;
        
        // Determinar resultado final
        let resultFinal;
        if (this.totalScore <= 12) {
            resultFinal = "Nivel bajo";
        } else if (this.totalScore <= 21) {
            resultFinal = "Nivel medio";
        } else {
            resultFinal = "Nivel alto";
        }
        
        // Guardar en base de datos
        try {
            const response = await fetch('save_test_results.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    userId: this.userId,
                    answers: this.answers,
                    totalScore: this.totalScore,
                    resultFinal: resultFinal
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showCompletionMessage();
            } else {
                console.error('Error guardando resultados:', data.message);
                this.showCompletionMessage(); // Mostrar mensaje de todos modos
            }
        } catch (error) {
            console.error('Error guardando resultados:', error);
            this.showCompletionMessage(); // Mostrar mensaje de todos modos
        }
    }
    
    // Mostrar mensaje de completado
    showCompletionMessage() {
        document.getElementById('welcomeMessage').style.display = 'none';
        document.getElementById('questionContainer').style.display = 'none';
        document.getElementById('completionMessage').style.display = 'block';
        document.getElementById('loginRequired').style.display = 'none';
        document.getElementById('alreadyCompleted').style.display = 'none';
    }
    
    // Cerrar chatbot
    closeChatbot() {
        const chatbot = document.getElementById('custom-chatbot');
        if (chatbot) {
            chatbot.remove();
        }
    }
}

// Inicializar chatbot cuando el DOM esté listo
let chatbot;
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        chatbot = new CustomChatbot();
    });
} else {
    chatbot = new CustomChatbot();
} 