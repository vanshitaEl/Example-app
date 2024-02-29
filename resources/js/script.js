const button = document.querySelector("button")

button.addEventListener("click", () => {
    Notification.requestPermission().then(perm => {
        if (perm === "granted") {
            const notification = new Notification("Example Notification", {
                body: "Notification",
            
               
            })
            notification.addEventListener("error", e => {
                alert("error");
            })
        }
    })
})

let notification;
let interval;

document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "hidden") {
        const leaveDate = new Date();
        interval = setInterval(() => {
            notification = new Notification("Come back please", {
                body: `You have been gone for ${(Math.round(new Date() - leaveDate) / 1000)} seconds`,
                tag: "came back",
            });
        }, 100);
    } else {
        notification.close();
        clearInterval(interval); // Clear the interval when the document is visible
    }
});
