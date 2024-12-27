

if("serviceWorker" in navigator){
    navigator.serviceWorker.register("pwa/sw.js")
     .then((reg)=> console.log("sw loaded ok"))
     .catch((err)=> console.log('sw failed ',err))
}