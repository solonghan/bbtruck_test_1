// importScripts('https://code.jquery.com/jquery-3.3.1.slim.min.js');
importScripts('https://www.gstatic.com/firebasejs/5.0.4/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/5.0.4/firebase-messaging.js');

var config = {
    messagingSenderId: "16568070192"
};

firebase.initializeApp(config);
messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    const promiseChain = clients.matchAll({
		type: 'window',
		includeUncontrolled: true
	})
	.then((windowClients) => {
		for (let i = 0; i < windowClients.length; i++) {
		  const windowClient = windowClients[i];
		  windowClient.postMessage(payload.data);
		}
	})
	.then(() => {
		// return registration.showNotification(payload.data.title, {
		// 			body: payload.data.message,
		// 			icon: 'assets/img/icon.png',
		// 			vibrate: [200, 100, 200, 100, 200, 100, 200],
		// 			tag: 'vibration'+Math.random()
		// 	    });
	});
});
