const countryCount = 238;
const hideoutTypeCount = 4;
// const missionTypeCount = 7;
// const specialityCount = 16;


function newUser(category = "person", number = 0) {
	fetch("https://randomuser.me/api/")
		.then((response) => {
	  // get the response
	  if (response.ok) {
				return response.json();
	  } else {
				new Error("Erreur réponse HTTP");
	  }
		})
		.then((user) => {
			// if the promise went OK
			switch (category) {
				case "person":
					displayPerson(user);			  
					break;
				case "hideout":
					displayHideout(user, number);
					break;

			
				default:
					break;
			}
		}, (error) => {
	  // if the promise failed
	  console.error(error);
		});
}

/**
 * Generates a random country.
 */
function generateCountry() : number {
	return Math.ceil(Math.random()*countryCount);
}

/**
 * Generates a random hideout type.
 */
function generateHideoutType() : number {
	return Math.ceil(Math.random()*hideoutTypeCount);
}
  
  
function displayHideout(user, number) {
	// address
	const loc : JSON = user.results[0].location;
	
	console.log(`("${loc.street.number} ${loc.street.name}, ${loc.postcode} ${loc.city}", ${number}, ${generateHideoutType()}),`);
}
  
function displayPerson(user) {
	// name and first name
	const {first, last} = user.results[0].name;
	// date of birth : only the "YYYY-MM-DD" part of ISO Date
	const dob : string = user.results[0].dob.date.split("T")[0];
	// random country code
	const country : number = generateCountry();
	
	console.log(`("${first}", "${last}", STR_TO_DATE("${dob}", "%Y-%m-%d"), ${country}),`);
}

/**
 * Generates n random persons with randomuser API, and displays the results
 * on the console, so they can directly be used in SQL INSERT queries.
 * @param n number of persons to be created
 */
export const generatePersons = (n : number) : void => {
	console.log(`Génération de ${n} personnes aléatoires...`);
	for (let i = 0; i < n; i++) {
		newUser("person");
	}
};

/**
 * Generates one random hideout per country, and displays the results
 * on the console, so they can directly be used in SQL INSERT queries.
 */
export const generateHideouts = () : void => {
	console.log(`Génération de ${countryCount} planques aléatoires...`);
	// with a delay to avoid overload
	let i = 0;
	const interval = setInterval(() => {
		if (i == countryCount) {
			clearInterval(interval);
		} else {
			newUser("hideout", ++i);
		}
	}, 100);
};