document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.getElementById('lookup');
    const resultDiv = document.getElementById('result');
    const countryInput = document.getElementById('country');

    lookupButton.addEventListener('click', () => {
        const country = countryInput.value.trim();

        // Construct the URL with the country parameter
        let url = 'world.php';
        if (country !== '') {
            // adds the country to the query parameter 
            url += '?country=' + encodeURIComponent(country);
        }

        // Use Fetch API to retrieve data from world.php
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not OK. Status: ${response.status}`);
                }
                return response.text(); // Get the response as text
            })
            .then(data => {
                // Insert nto the result div
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                // If there's an error (e.g. network or server issue)
                console.error('Error fetching data:', error);
                resultDiv.innerHTML = '<p>An error occurred while fetching data.</p>';
            });
    });
});
