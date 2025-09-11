<?php
require_once 'user_session.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - AICROOM | Inteligencia Artificial para Evaluar Talento Humano</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php generateUserScript(); ?>
</head>
<body <?php echo generateUserAttributes(); ?> class="<?php echo generateAdminClass(); ?>">
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <a href="index.php" class="logo">
                    <img src="images/logo.jpeg" alt="Logo AICROOM" style="height: 40px; margin-right: 10px;">
                    AICROOM
                </a>
                
                <!-- Menú desktop -->
                <ul class="nav-menu">
                    <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                    <li class="nav-item"><a href="como-funciona.html" class="nav-link">Cómo funciona</a></li>
                    <li class="nav-item"><a href="empresa.html" class="nav-link">Sobre nosotros</a></li>
                    <li class="nav-item"><a href="contacto.html" class="nav-link">Contacto</a></li>
                    <li class="nav-item admin-only" id="results-desktop"><a href="resultados.php" class="nav-link">Resultados</a></li>
                    <li class="nav-item"><a href="chatbot.html" class="nav-link">Evaluación IA</a></li>
                </ul>
                
                <!-- Menú usuario desktop -->
                <div class="user-menu">
                    <span class="user-name">EMA (usuario)</span>
                    <button class="logout-btn" onclick="window.location.href='logout.php'">Cerrar sesión</button>
                </div>
                
                <!-- Botón hamburguesa -->
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            
            <!-- Menú móvil -->
            <div class="mobile-menu" id="mobileMenu">
                <ul class="mobile-nav-menu">
                    <li class="mobile-nav-item"><a href="index.php" class="mobile-nav-link">Inicio</a></li>
                    <li class="mobile-nav-item"><a href="como-funciona.html" class="mobile-nav-link">Cómo funciona</a></li>
                    <li class="mobile-nav-item"><a href="empresa.html" class="mobile-nav-link">Sobre nosotros</a></li>
                    <li class="mobile-nav-item"><a href="contacto.html" class="mobile-nav-link">Contacto</a></li>
                    <li class="mobile-nav-item admin-only" id="results-mobile"><a href="resultados.php" class="mobile-nav-link">Resultados</a></li>
                    <li class="mobile-nav-item"><a href="chatbot.html" class="mobile-nav-link">Evaluación IA</a></li>
                </ul>
                <div class="mobile-user-section">
                    <div class="mobile-user-name">EMA (usuario)</div>
                    <button class="mobile-logout-btn" onclick="window.location.href='logout.php'">Cerrar sesión</button>
                </div>
            </div>
            
            <!-- Overlay para cerrar menú -->
            <div class="overlay" id="overlay"></div>
        </nav>
    </header>

    <!-- Hero Section Impactante -->
    <section class="hero">
      <div class="container">
        <h1>Simula entrevistas con IA para evaluar talento humano</h1>
        <p class="hero-subtitle">Descubre cómo AICROOM revoluciona la selección de personal con Inteligencia Artificial que simula entrevistas psicológicas y muestra resultados instantáneos en pantalla.</p>
        <div class="hero-image">
          <img src="images/Captura de pantalla 2025-07-18 151428.png" alt="Simulador de AICROOM">
        </div>
      </div>
    </section>

    <!-- Sección de Accesibilidad -->
    <section class="accessibility-section">
      <div class="container accessibility-content">
        <div class="accessibility-text">
          <h2><i class="fas fa-universal-access"></i> Accesibilidad sin barreras</h2>
          <p>En AICROOM creemos en la accesibilidad. Por eso, nuestro simulador de entrevista con IA está disponible directamente en esta página, sin necesidad de agendar una demostración o registrarse.</p>
          <p>Puedes interactuar ahora mismo con nuestro chatbot, explorar las preguntas simuladas y descubrir cómo evaluamos talento humano. Todo está diseñado para que lo pruebes libremente, cuando quieras.</p>
        </div>
        <div class="accessibility-image">
            <img src="images/imagen_3.png" alt="Simulador accesible" class="img-responsive-center">
        </div>
      </div>
    </section>

    <!-- Beneficios Clave -->
    <section class="benefits-section">
      <div class="container">
        <div class="section-header">
          <h2>Ahorra la curva de aprendizaje</h2>
          <p>Transforma tu proceso de selección con tecnología inteligente y resultados inmediatos</p>
        </div>
        <div class="benefits-grid">
          <div class="benefit-card">
            <div class="benefit-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h3>El 37% de las PYMES fracasan por:</h3>
            <ul type="none">
              <li>Errores en el proceso de selección de personal</li>
              <li>Pérdida de productividad: retrasos, errores y baja eficiencia</li>
              <li>Pérdida de oportunidades: se descuidan proyectos clave</li>
              <li>Conflictos laborales</li>
            </ul>
          </div>
          <div class="benefit-card">
            <div class="benefit-icon">
              <i class="fas fa-skull-crossbones"></i>
            </div>
            <h3>Valle de la muerte</h3>
            <ul type="none">
              <li>De 1.7 millones de PYMES mueren 1.4 millones</li>
              <li>Falta de capital para contratar áreas expertas en RRHH</li>
              <li>Contrataciones erróneas</li>
              <li>No implementar herramientas TMS (Talent Management System)</li>
            </ul>
          </div>
          <div class="benefit-card">
            <div class="benefit-icon">
              <i class="fas fa-piggy-bank"></i>
            </div>
            <h3>Reducción de costos y productividad</h3>
            <ul type="none">
              <li>Reduce hasta 30% de áreas RRHH</li>
              <li>Aumenta hasta 80% la tasa de efectividad en contrataciones</li>
              <li>Hasta 35% menos la rotación de personal</li>
              <li>Incremento del 20% al 35% en la productividad</li>
            </ul>
          </div>
        </div>
        <div style="margin-top:2em; text-align:center; font-style:italic;">
          "AICROOM descubre más allá de los curriculum vitae, se enfoca en la productividad y en las habilidades blandas de la persona. Cuando hay habilidades hay talento, y cuando hay talento hay resultados."
        </div>
      </div>
    </section>

    <!-- Cómo Funciona -->
    

    <!-- Sustituir testimonios por marcas -->
    <section class="brands-section">
      <div class="container">
        <div class="section-header">
          <h2>Marcas que confían en nosotros y nuestro proyecto</h2>
          <p>Empresas de prestigio en México</p>
        </div>
        <div class="brands-logos">
          <img src="images/Logo_televisa.png" alt="Televisa">
          <img src="images/Logo_santander.png" alt="Santander">
          <img src="images/Logo_monte_piedad.png" alt="Monte de Piedad">
          <img src="images/santanderx.png" alt="Santander X Explorer">
          <img src="images/centro.png" alt="Centro">
          <img src="images/bert_negocios.png" alt="Bert Negocios">
          <img src="images/hoteles_city.png" alt="Hoteles City">
          <img src="images/posible.png" alt="Posible">
        </div>
      </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <a href="index.html" class="logo-container">
                    <img src="images/logo.jpeg" alt="Logo AICROOM" class="logo">
                    <span class="logo-text">AICROOM</span>
                </a>
                <p id="parra-footer">Revolucionando los procesos de selección con Inteligencia Artificial.</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/share/16pNKXdseF/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h4>Enlaces rápidos</h4>
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="como-funciona.html">Cómo funciona</a></li>
                    <li><a href="empresa.html">Sobre nosotros</a></li>
                    <li><a href="contacto.html">Contáctanos</a></li>
                    <li><a href="chatbot.html">Evaluación IA</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Contacto</h4>
                <ul class="contact-info">
                    <li><i class="fas fa-envelope"></i> geovaniromero2020@gmail.com</li>
                    <li><i class="fas fa-phone"></i> 5647594918</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p style="font-weight:bold;">&copy; 2025 AICROOM. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="main.js"></script>
    <script src="admin_nav.js"></script>
    <script src="nav-mobile.js"></script>
    <script src="user-menu.js"></script>
</body>
</html>