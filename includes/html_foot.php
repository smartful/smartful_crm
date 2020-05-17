    <footer class="footer">
      <?php if (isset($_SESSION['id_user'])) : ?>
        <div class="text-center">
            <a href="?deconnexion"><span class="badge badge-light">Déconnexion</span></a>
        </div>
        <br>
      <?php endif; ?>

      <div id="footer">
        <div class="links">
          <div class="webLinks">
            <a href="https://www.smartful.fr/">SMARTFUL</a>
            <span class="footer">|</span>
            <a href="https://github.com/smartful">Github</a>
            <span class="footer">|</span>
            <a href="https://www.linkedin.com/in/remi-matthieu-rodrigues-30633852/">Linkedin</a>
          </div>
        </div>
        <div class="copyright"> ©2020 SMARTFUL - Rémi Matthieu RODRIGUES</div>
      </div>
    </footer>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>