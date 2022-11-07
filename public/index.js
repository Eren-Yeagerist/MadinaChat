if("serviceWorker" in navigator){
    navigator.serviceWorker.register("sw.js").then(registration => {
        console.log("sw registered");
        console.log(registration);
    }).catch(error => {
        console.log("sw registered failed");
        console.log(error);
    });
}