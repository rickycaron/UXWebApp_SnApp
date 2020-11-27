document.getElementById("takePictureButton").onclick = function selectFile() {
    document.getElementById("inputFile").click();
}

function sendIdentification() {
    const files = [...document.querySelector('input[type=file]').files];
    const promises = files.map((file) => {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (event) => {
                const res = event.target.result;
                console.log(res);
                resolve(res);
            };
            reader.readAsDataURL(file)
        })
    });

    Promise.all(promises).then((base64files) => {
        console.log(base64files);

        const data = {
            api_key: "ufp8UeKvKHjc3Qv8997x6MGrMTylzl3Sg6xNqgzjAQvmurLzTP",
            images: base64files,
            modifiers: ["crops_fast", "similar_images"],
            plant_language: "en",
            plant_details: ["common_names",
                "url",
                "name_authority",
                "wiki_description",
                "taxonomy",
                "synonyms"]
        };

        fetch('https://api.plant.id/v2/identify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(data => {
                suggestions = data["suggestions"];
                plantDetails = suggestions[0]["plant_details"];
                console.log('Success:', data);
                console.log('suggestions', suggestions);
                console.log('suggestions', plantDetails);
                //printInformation(data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    })

};




function printInformation(input) {
    suggestions = input["suggestions"];
    metaData = input["meta_data"];
    plantDetails = suggestions[0]["plant_details"];
    plantDescription = plantDetails["wiki_description"];
    document.getElementById("speciesNamePlaceholder").value = plantDetails.common_names[0];
    document.getElementById("scientificNamePlaceholder").value = plantDetails.scientific_name;
    document.getElementById("DescriptionPlaceholder").value = plantDescription.value;
    document.getElementById("datePlaceholder").value = metaData.date;

    let now = new Date();
    let time = leadZero(now.getHours()) + ":" + leadZero(now.getMinutes());
    document.getElementById("timePlaceholder").value = time;

    // $('#processingText').style.display = 'none';
}

function leadZero(_something) {
    if(parseInt(_something)<10) return "0"+_something;
    return _something;//else
}

document.getElementById("useLocationCheckbox").onclick = function Location() {
    if (document.getElementById("useLocationCheckbox").checked == true) {
        getLocation();
    }
    else {
        document.getElementById("LocationPlaceholder").value = '';
    }

}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        document.getElementById("LocationPlaceholder").value = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    let curLocation = position.coords.latitude + ", " + position.coords.longitude;
    document.getElementById("LocationPlaceholder").value = curLocation;
}


