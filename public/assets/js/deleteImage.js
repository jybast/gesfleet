window.onload = () => {
    // Get links delete
    let links = document.querySelectorAll("[data-delete]");

    // loop on links
    for(let link of links){
        // listen clic
        link.addEventListener("click", function(e){
            // stop navigation
            e.preventDefault()

            // confirmation
            if(confirm("Voulez-vous supprimer cette image ?")){
                // send request Ajax to href of link with method DELETE
                // this is the link
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // get response JSON
                    response => response.json()
                ).then(data => {
                    // if success delete DIV with class image
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }
}