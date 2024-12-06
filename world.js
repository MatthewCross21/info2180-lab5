document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookup-cities');
    const resultDiv = document.getElementById('result');
    const countryInput = document.getElementById('country');
  
    // Function to fetch data from world.php based on context ("countries" or "cities")
    function fetchData(context) {
      const country = countryInput.value.trim();
      let url = 'world.php';
  
      // If a country name is provided, add as a query parameter
      if (country !== '') {
        url += '?country=' + encodeURIComponent(country);
      }
  
      // Add a context parameter to differentiate between fetching countries or cities
      if (context === 'cities') {
        url += (country !== '' ? '&' : '?') + 'context=cities';
      }
  
      fetch(url)
        .then(response => {
          if (!response.ok) {
            throw new Error(`Network response was not ok, status: ${response.status}`);
          }
          return response.text();
        })
        .then(data => {
          resultDiv.innerHTML = data;
        })
        .catch(error => {
          console.error('Error fetching data:', error);
          resultDiv.innerHTML = '<p>An error occurred while fetching data.</p>';
        });
    }
  
    // Event listeners
    lookupButton.addEventListener('click', () => {
      fetchData('countries');
    });
  
    lookupCitiesButton.addEventListener('click', () => {
      fetchData('cities');
    });
  });
  