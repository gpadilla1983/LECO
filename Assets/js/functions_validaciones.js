// const email = document.querySelector(".valiemail");

// const error = document.querySelector(".text-error");

// error.style.display="none";


// let regExp = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

// function check(){
//     if(email.value.match(regExp)){
//         email.style.bordercolor="#27ae60 ";
//         email.style.solid ="green";
//         email.style.background ="#eafaf1";
//         error.style.display="none";
//         //jQuery('.btnvalida').prop('disabled', false);
        
//     }else{
//         email.style.bordercolor="#e74c3c";
//         email.style.solid="red";
//         email.style.background ="#fceae9";
//         error.style.display="block";
//         //jQuery('.btnvalida').prop('disabled', true);
       
//     }

//     if(email.value == ""){
//         email.style.bordercolor = "lightgrey";
//         email.style.background = "#fff";
//         error.style.display="none";
//         //jQuery('.btnvalida').prop('disabled', true);
//     }

// }

// const email2 = document.querySelector(".valiemail2");

// const error2 = document.querySelector(".texterror2");


// error2.style.display="none";


// let regExp2 = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

// function check2(){
//     if(email2.value.match(regExp2)){
//         email2.style.bordercolor="#27ae60 ";
//         email2.style.solid ="green";
//         email2.style.background ="#eafaf1";
//         error2.style.display="none";
//         //jQuery('.btnvalida2').prop('disabled', false);
        
//     }else{
//         email2.style.bordercolor="#e74c3c";
//         email2.style.solid="red";
//         email2.style.background ="#fceae9";
//         error2.style.display="block";
//         error2.style.color = "red";
//         //jQuery('.btnvalida2').prop('disabled', true);
       
//     }

//     if(email2.value == ""){
//         email2.style.bordercolor = "lightgrey";
//         email2.style.background = "#fff";
//         error2.style.display="none";
//         //jQuery('.btnvalida2').prop('disabled', true);
//     }

// }

//Función para validar un RFC
// Devuelve el RFC sin espacios ni guiones si es correcto
// Devuelve false si es inválido
// (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,

    //Obtener el digito esperado
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}


//Handler para el evento cuando cambia el input
// -Lleva la RFC a mayúsculas para validarlo
// -Elimina los espacios que pueda tener antes o después
