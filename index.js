


function sendMail() {
  var params = {
    name: document.getElementById("name").value,
    email: document.getElementById("national_id").value
  };

  const serviceID = "service_s1ddnzs";
  const templateID = "template_evva7ar";

    emailjs.send(serviceID, templateID, params)
    .then(res=>{
        document.getElementById("name").value = "";
        document.getElementById("national_id").value = "";
        console.log(res);
        alert("Your message sent successfully!!")

    })
    .catch(err=>console.log(err));

}