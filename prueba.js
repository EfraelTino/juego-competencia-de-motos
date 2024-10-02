async function enviarmensajenumero() {
    try {
      const usuario = "MTMILO";
      const contrasena = "OnPfqs8LK2";
  
      const credenciales = `${usuario}:${contrasena}`;
  
      const credencialesBase64 = btoa(credenciales);
  
      const numero = "51915068001"; 
      const texto = "Mensaje de texto";
  
      const url = "https://satelco.app/Mts/Soporte/Api/basic/EnvioMT";
  
      const response = await fetch(`${url}?numero=${numero}&Texto=${encodeURIComponent(texto)}`, {
        method: "POST",
        headers: {
          Authorization: `Basic ${credencialesBase64}`,
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({}),
      });
  
      console.log(response);
      if (response.ok) {
        const data = await response.json();
        console.log("Respuesta del servidor:", data);
      } else {
        throw new Error("Error en la petición");
      }
    } catch (error) {
      console.error("Error al realizar la petición:", error);
    }
  }
  
  enviarmensajenumero();
  