<!-- FOOTER -->
<footer class="mt-3 p-2 w-100 " style="background-color: #08143d; position:static; bottom:0">
    <section>
        <a target="_blank" href="https://www.municoquimbo.cl">
            <!--<img src="/img/logo_mini_white.png" />-->
            <img src="public/img/logoMuni.png">
        </a>

        <div class="divLineFooter">
            <p class="">
                Desarrollado por Oficina de Ingeniería y Desarrollo<br>
                Departamento de Gestión de Sistemas y TICS<br>
                Ilustre Municipalidad de Coquimbo<br>
                <span id="year"></span>
            </p>
        </div>
    </section>
</footer>
<script>
    //obtiene el año actual
    document.getElementById('year').textContent = new Date().getFullYear();
</script>

<!--FIN FOOTER-->