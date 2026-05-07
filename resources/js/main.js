window.scrollToElement = function(element, parent = null, padding_top = 0, behavior = 'smooth'){
    let header_height = parent != null ? document.querySelector("header").offsetHeight : 0;
    parent = parent ?? window;
    let y = element.getBoundingClientRect().top + $(parent).scrollTop() - header_height - padding_top;
    
    parent.scrollTo({top: y * -1, behavior: behavior});
}

window.format_date = function(date, format = "Y-m-d"){
    if(format == "Y-m-d"){
        return date.getFullYear() + "-" + String(date.getMonth() + 1).padStart(2, '0') + "-" + String(date.getDate()).padStart(2, '0');
    }
    else if(format == "d/m/Y"){
        return String(date.getDate()).padStart(2, '0') + "/" + String(date.getMonth() + 1).padStart(2, '0') + "/" + date.getFullYear();
    }
}

window.openModal = function(modal, size = null){
    if(size){
        modal._element.querySelector(".modal-dialog").setAttribute("class", "modal-dialog modal-" + size);
    }
    
    modal.show();
}

// HTMX functions
window.downloadBase64File = function(event) {
    if (event.detail.xhr.status === 200) {
        const response = JSON.parse(event.detail.xhr.response);
        
        // Create a Blob from the Base64 string
        const byteCharacters = atob(response.base64);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);
        const fileBlob = new Blob([byteArray], { type: response.mimetype });

        // Create a download link
        const link = document.createElement("a");
        link.href = URL.createObjectURL(fileBlob);
        link.download = response.filename;
        
        // Trigger download
        document.body.appendChild(link);
        link.click();
        
        // Cleanup
        document.body.removeChild(link);
        URL.revokeObjectURL(link.href);
    }
}

window.openPdf = function(event) {
    if (event.detail.xhr.status === 200) {
        const byteCharacters = atob(event.detail.xhr.response);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const byteArray = new Uint8Array(byteNumbers);
        const file = new Blob([byteArray], { type: 'application/pdf' });

        const fileURL = URL.createObjectURL(file);
        window.open(fileURL, '_blank');
    }
}

window.htmx_target_loading = function(event){
    $(event.detail.target).html(`<div class="col-12 p-5 text-center"><i class="fa-solid fa-arrows-rotate fa-spin"></i></div>`);
}