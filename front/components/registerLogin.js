document.querySelector("#registerButton").addEventListener("click", register);
document.querySelector("#loginButton").addEventListener("click", login);

async function register(e) {
  e.preventDefault();
  const reqRegister = new FormData(document.querySelector("#registerForm"));
  const requestOptions = {
    method: "POST",
    body: reqRegister,
  };
  let registerUser = await fetch("../../back/Controller/authController.php", requestOptions);
  registerUser = await registerUser.json();
  if(registerUser.success == true){
    window.location.href = "toDoList.php";
  }
}

async function login(e) {
    e.preventDefault();
    const reqLogin = new FormData(document.querySelector("#loginForm")); 
    const requestOptions = {
      method: "POST",
      body: reqLogin,
    }; 
    let loginUser = await fetch("../../back/Controller/authController.php", requestOptions); 
    loginUser = await loginUser.json();
    if(loginUser.success == true){
      window.location.href = "toDoList.php";
    }
  }

