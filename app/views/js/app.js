
window.addEventListener('load',() => {
    
    const form = document.querySelector('#formulario')
    const nombre = document.getElementById('nombre')
    const username = document.getElementById('username')
    const password = document.getElementById('password')
    const email = document.getElementById('email')
    const telefono = document.getElementById('telefono')
    const direccion = document.getElementById('direccion')
    
    form.addEventListener('submit', (e) => {
        //e.preventDefault();
        validaCampos()
    })
    
    const validaCampos = ()=> {
        //capturar los valores ingresados por el usuario
        const nombreValor = nombre.value.trim()
        const usernameoValor = username.value.trim()
        const passwordValor = password.value.trim()
        const emailValor = email.value.trim()
        const telefonoValor = telefono.value.trim()
        const direccionValor = direccion.value.trim()

        //validando campo nombre
        const erNombre = /^[a-zA-ZÀ-ÿ\s]{1,40}$/
        if(!nombreValor){
            validaFalla(nombre, 'Campo vacío')
        }else if(!nombreValor.match(erNombre)){
            validaFalla(nombre, 'El nombre debe iniciar con Mayusculas')
        }else{
            validaOk(nombre, 'ok')
        }

        //validando campo username
        if(!usernamenValor){
            validaFalla(username, 'Debes escribir al menos un usuario')            
        }else{
            validaOk(username, 'ok')
        }

         //validando campo email
         const erEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/   
         if(!emailValor){
            validaFalla(email, 'Campo vacío')            
        }else if(!emailValor.match(erEmail)) {
            validaFalla(email, 'El e-mail no es válido')
        }else{
            validaOk(email, 'ok')
        }

        //validando campo telefono
        const erTel = /^(\+34|0034|34)?[6789]\d{8}$/          
        if(!telefonoValor) {
            validaFalla(telefono, 'Campo vacío')
        } else if (telefonoValor.length < 12) {             
            validaFalla(telefono, 'Debe tener 9 caracteres cómo mínimo y prefijo +34.')
        } else if (!telefonoValor.match(erTel)) {
            validaFalla(telefono, 'Debe ser un numero español.')
        } else {
            validaOk(telefono, 'ok')
        }

        //validando campo direccion
        if(!direccionValor){
            validaFalla(direccion, 'Debes escribir al menos un Direccion')            
        }else{
            validaOk(direccion, 'ok')
        }
        
    } 

    const validaFalla = (input, msje) => {
        const formControl = input.parentElement
        const aviso = formControl.querySelector('p')
        aviso.innerText = msje
        formControl.className = 'form-control falla'
    }
    
    const validaOk = (input, msje) => {
        const formControl = input.parentElement
        const aviso = formControl.querySelector('p')
        aviso.innerText = msje
        formControl.className = 'form-control ok'
        
    }
})
