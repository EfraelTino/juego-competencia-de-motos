let numeroAleatorio = Math.floor(Math.random() * 9000) + 1000;
console.log(numeroAleatorio);

function enviarMensaje() {
  const myHeaders = new Headers();
  myHeaders.append(
    "Authorization",
    "App d36dd3f340eebda7d956c21da9bf834c-c52577a4-43fe-46aa-abf6-80cf227686ef"
  );
  myHeaders.append("Content-Type", "application/json");
  myHeaders.append("Accept", "application/json");

  const raw = JSON.stringify({
    messages: [
      {
        destinations: [{ to: "573504470872" }],
        from: "447491163443",
        text: "Hola amigooooo",
      },
    ],
  });

  const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: raw,
    redirect: "follow",
  };

  fetch("https://38gxw1.api.infobip.com/sms/2/text/advanced", requestOptions)
    .then((response) => response.text())
    .then((result) => console.log(result))
    .catch((error) => console.error(error));
}
