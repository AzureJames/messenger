const form = document.querySelector(".msg-send-form"),
// incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field") || "",
sendBtn = document.querySelector(".send_msg"),
chatBox = document.querySelector(".homeflex"),
hidden = document.querySelector("div.hidden");

 form.onsubmit = (e)=>{
     e.preventDefault();
 }

sendBtn.onclick = ()=>{
    console.log("sendbtn");
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "msg-send-form.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom(); //btn chat clicked, creates a msg insert chat,sends form data... now nothing works, would have to revert to gh
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
    }

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "friend-list.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            console.log(data);
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "multipart/form-data");
    xhr.send("sender=" + hidden.innerHTML);
    //no var for that id yet... it's post?
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  