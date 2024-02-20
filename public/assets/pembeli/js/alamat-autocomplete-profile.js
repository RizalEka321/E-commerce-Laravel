function addressAutocomplete(containerElement, callback, options) {
    const inputContainerElement = document.createElement("div");
    inputContainerElement.setAttribute("class", "input-container");
    containerElement.appendChild(inputContainerElement);

    const inputElement = document.createElement("input");
    inputElement.setAttribute("type", "text");
    inputElement.setAttribute("class", "form-control text-muted");
    inputElement.setAttribute("id", "alamat");
    inputElement.setAttribute("name", "alamat");
    inputElement.setAttribute("required", "required");
    inputElement.setAttribute("autofocus", "autofocus");
    inputElement.setAttribute("autocomplete", "address");
    inputElement.setAttribute("value", document.getElementById('temp').innerHTML);
    inputElement.setAttribute("placeholder", options.placeholder);
    inputContainerElement.appendChild(inputElement);

    const MIN_ADDRESS_LENGTH = 3;
    const DEBOUNCE_DELAY = 300;
    let currentTimeout;
    let currentPromiseReject;
    let currentItems;
    let autocompleteItemsElement;

    inputElement.addEventListener("input", function (e) {
        const currentValue = this.value;

        if (currentTimeout) {
            clearTimeout(currentTimeout);
        }

        if (currentPromiseReject) {
            currentPromiseReject({
                canceled: true,
            });
        }

        if (!currentValue || currentValue.length < MIN_ADDRESS_LENGTH) {
            closeDropDownList();
            return false;
        }

        currentTimeout = setTimeout(() => {
            currentTimeout = null;

            const promise = new Promise((resolve, reject) => {
                currentPromiseReject = reject;
                const apiKey = "646f5a0df02b42ba90189cf71d32f8aa";
                const url = `https://api.geoapify.com/v1/geocode/autocomplete?text=${encodeURIComponent(
                    currentValue
                )}&format=json&limit=5&apiKey=${apiKey}&lang=id`;

                fetch(url)
                    .then((response) => {
                        currentPromiseReject = null;

                        if (response.ok) {
                            response.json().then((data) => resolve(data));
                        } else {
                            response.json().then((data) => reject(data));
                        }
                    })
                    .catch((error) => reject(error));
            });

            promise.then(
                (data) => {
                    currentItems = data.results;

                    closeDropDownList();

                    autocompleteItemsElement = document.createElement("div");
                    autocompleteItemsElement.setAttribute("class", "autocomplete-items");
                    inputContainerElement.appendChild(autocompleteItemsElement);

                    data.results.forEach((result, index) => {
                        const itemElement = document.createElement("div");
                        itemElement.innerHTML = '<i class="fas fa-map-marker-alt"> </i> ' + result.formatted;
                        autocompleteItemsElement.appendChild(itemElement);

                        itemElement.addEventListener("click", function (e) {
                            inputElement.value = currentItems[index].formatted;
                            callback(currentItems[index]);

                            const latitude = currentItems[index].lat;
                            const longitude = currentItems[index].lon;
                            console.log(latitude);
                            console.log(longitude);
                            document.getElementById("latitude").value = latitude;
                            document.getElementById("longitude").value = longitude;

                            closeDropDownList();
                        });
                    });
                },
                (err) => {
                    if (!err.canceled) {
                        console.log(err);
                    }
                }
            );
        }, DEBOUNCE_DELAY);
    });

    function closeDropDownList() {
        if (autocompleteItemsElement) {
            inputContainerElement.removeChild(autocompleteItemsElement);
            autocompleteItemsElement = null;
        }
    }

    document.addEventListener("click", function (e) {
        if (e.target !== inputElement) {
            closeDropDownList();
        } else if (!containerElement.querySelector(".autocomplete-items")) {
            var event = document.createEvent("Event");
            event.initEvent("input", true, true);
            inputElement.dispatchEvent(event);
        }
    });
}

addressAutocomplete(document.getElementById("autocomplete-container"), (data) => {
    console.log("Selected option: ");
    console.log(data);
}, {
    placeholder: "Enter your address"
});