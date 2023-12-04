// const api_url = "http://localhost:3000/api/";
// const path = "auth/";

function handleLogin(event) {
  event.preventDefault();

  var form = document.getElementById("login-form");
  const email = form.email.value;
  const password = form.password.value;

  // if ((email === "" && password === "") || (email === null && password === null)) {

  //   toastr.error("Preencha as Credenciais de Acesso", "Erro!");

  // } else if (email === "admin@rnu.pt" && password === "admin") {
    
  //   toastr.success("Credenciais Corretas!", "Sucesso!");
  //   setTimeout(() => {
  //     window.location.href = "../admin/index";
  //   }, 650);

  // } else if (email === "secretaria@rnu.pt" && password === "secretaria") {

  //   toastr.success("Credenciais Corretas!", "Sucesso!");
  //   setTimeout(() => {
  //     window.location.href = "../office/index";
  //   }, 650);

  // } else {

  //   toastr.error("Credenciais de Acesso Incorretas", "Erro!");

  // }

  const formData = new FormData();

  formData.append("action", "login");
  formData.append("email", form.email.value);
  formData.append("password", form.password.value);

  const data = {
    email: email,
    password: password,
  };

  const requestOptions = {
    method: "POST",
    // headers: {
    //   "Content-Type": "application/json",
    // },
    body: formData,
  };

  fetch("../../api/auth.php", requestOptions)
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        toastr.error(data.error, "Erro!");
      } else if (data.status === true) {
        toastr.success("Credencias Corretas!", "Sucesso!");
      
          if (data.user_role[0] === "Admin") {
            setTimeout(() => {
              window.location.href = "../admin/index";
            }, 650);
          } else if (data.user_role[0] === "Office") {
            setTimeout(() => {
              window.location.href = "../office/index";
            }, 650);
          } else {
            toastr.error("Erro ao Verificar o Perfil", "Erro!");
          }
      } else if (data.status === false) {
        toastr.error("Credencias Incorretas!", "Erro!");
        console.log(data);
      }
    })
    .catch((error) => {
      toastr.error(error, "Erro!");
    });
}
