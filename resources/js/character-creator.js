// Modificadores de D&D 5e
const dndModifiers = {
    races: {
        human: {
            name: "Humano",
            bonuses: { str: 1, dex: 1, con: 1, int: 1, wis: 1, cha: 1 },
        },
        elf: {
            name: "Elfo",
            bonuses: { dex: 2 },
        },
        dwarf: {
            name: "Enano",
            bonuses: { con: 2 },
        },
        halfling: {
            name: "Mediano",
            bonuses: { dex: 2 },
        },
        dragonborn: {
            name: "Draconido",
            bonuses: { str: 2, cha: 1 },
        },
        gnome: {
            name: "Gnomo",
            bonuses: { int: 2 },
        },
        half_elf: {
            name: "Semielfo",
            bonuses: { cha: 2 }, // +1 a otros dos atributos a elección
        },
        half_orc: {
            name: "Semiorco",
            bonuses: { str: 2, con: 1 },
        },
        tiefling: {
            name: "Tiefling",
            bonuses: { int: 1, cha: 2 },
        },
    },

    classes: {
        barbarian: {
            name: "Bárbaro",
            primaryStat: "str",
            recommendation: "Alto en Fuerza y Constitución",
        },
        bard: {
            name: "Bardo",
            primaryStat: "cha",
            recommendation: "Alto en Carisma y Destreza",
        },
        cleric: {
            name: "Clérigo",
            primaryStat: "wis",
            recommendation: "Alto en Sabiduría y Constitución",
        },
        druid: {
            name: "Druida",
            primaryStat: "wis",
            recommendation: "Alto en Sabiduría y Constitución",
        },
        fighter: {
            name: "Guerrero",
            primaryStat: "str",
            recommendation: "Alto en Fuerza o Destreza, y Constitución",
        },
        monk: {
            name: "Monje",
            primaryStat: "dex",
            recommendation: "Alto en Destreza y Sabiduría",
        },
        paladin: {
            name: "Paladín",
            primaryStat: "str",
            recommendation: "Alto en Fuerza, Constitución y Carisma",
        },
        ranger: {
            name: "Explorador",
            primaryStat: "dex",
            recommendation: "Alto en Destreza y Sabiduría",
        },
        rogue: {
            name: "Pícaro",
            primaryStat: "dex",
            recommendation: "Alto en Destreza e Inteligencia",
        },
        sorcerer: {
            name: "Hechicero",
            primaryStat: "cha",
            recommendation: "Alto en Carisma y Constitución",
        },
        warlock: {
            name: "Brujo",
            primaryStat: "cha",
            recommendation: "Alto en Carisma y Constitución",
        },
        wizard: {
            name: "Mago",
            primaryStat: "int",
            recommendation: "Alto en Inteligencia y Destreza",
        },
    },
};

// Generador de nombres fantasy por raza
const fantasyNames = {
    human: {
        male: [
            "Aldric",
            "Gareth",
            "Roderick",
            "Thorne",
            "Viktor",
            "Marcus",
            "Cedric",
            "Edmund",
            "Roland",
            "Damian",
        ],
        female: [
            "Elara",
            "Lyra",
            "Morgana",
            "Seraphina",
            "Isolde",
            "Cordelia",
            "Rosalind",
            "Beatrice",
            "Gwendolyn",
            "Arabella",
        ],
    },
    elf: {
        male: [
            "Arannis",
            "Elrohir",
            "Galadriel",
            "Legolas",
            "Thranduil",
            "Celeborn",
            "Fëanor",
            "Finrod",
            "Glorfindel",
            "Haldir",
        ],
        female: [
            "Arwen",
            "Galadriel",
            "Lúthien",
            "Nimriel",
            "Tauriel",
            "Yavanna",
            "Celebrían",
            "Idril",
            "Melian",
            "Nienna",
        ],
    },
    dwarf: {
        male: [
            "Thorin",
            "Gimli",
            "Balin",
            "Dwalin",
            "Borin",
            "Durin",
            "Farin",
            "Thrain",
            "Nain",
            "Kili",
        ],
        female: [
            "Dis",
            "Kathra",
            "Mira",
            "Artin",
            "Vistra",
            "Darrak",
            "Eldeth",
            "Finellen",
            "Gunnloda",
            "Helja",
        ],
    },
    halfling: {
        male: [
            "Bilbo",
            "Frodo",
            "Samwise",
            "Merry",
            "Pippin",
            "Tobias",
            "Osborn",
            "Roscoe",
            "Willow",
            "Finnan",
        ],
        female: [
            "Elanor",
            "Rosie",
            "Lily",
            "Daisy",
            "Marigold",
            "Pearl",
            "Ruby",
            "Cora",
            "Merla",
            "Shaena",
        ],
    },
    dragonborn: {
        male: [
            "Arjhan",
            "Balasar",
            "Bharash",
            "Donaar",
            "Ghesh",
            "Heskan",
            "Kriv",
            "Medrash",
            "Nadarr",
            "Pandjed",
        ],
        female: [
            "Akra",
            "Biri",
            "Daar",
            "Farideh",
            "Harann",
            "Havilar",
            "Jheri",
            "Kava",
            "Korinn",
            "Mishann",
        ],
    },
    gnome: {
        male: [
            "Alston",
            "Boddynock",
            "Brocc",
            "Burgell",
            "Dimble",
            "Eldon",
            "Erky",
            "Fonkin",
            "Frug",
            "Gerbo",
        ],
        female: [
            "Bimpnottin",
            "Breena",
            "Caramip",
            "Carlin",
            "Donella",
            "Duvamil",
            "Ella",
            "Folkor",
            "Loopmottin",
            "Lorilla",
        ],
    },
    half_elf: {
        male: [
            "Aelric",
            "Berrian",
            "Carric",
            "Erdan",
            "Finnan",
            "Galinndan",
            "Hadarai",
            "Immeral",
            "Laucian",
            "Mindartis",
        ],
        female: [
            "Andraste",
            "Bethrynna",
            "Caelynn",
            "Drusilia",
            "Enna",
            "Faral",
            "Irann",
            "Jarsali",
            "Keyleth",
            "Lia",
        ],
    },
    half_orc: {
        male: [
            "Dench",
            "Feng",
            "Gell",
            "Henk",
            "Holg",
            "Imsh",
            "Keth",
            "Krusk",
            "Mhurren",
            "Ront",
        ],
        female: [
            "Baggi",
            "Emen",
            "Engong",
            "Kansif",
            "Myev",
            "Neega",
            "Ovak",
            "Ownka",
            "Shautha",
            "Vola",
        ],
    },
    tiefling: {
        male: [
            "Akmenos",
            "Amnon",
            "Barakas",
            "Damakos",
            "Ekemon",
            "Iados",
            "Kairon",
            "Leucis",
            "Melech",
            "Mordai",
        ],
        female: [
            "Akta",
            "Anakis",
            "Bryseis",
            "Criella",
            "Damaia",
            "Ea",
            "Kallista",
            "Lerissa",
            "Makaria",
            "Nemeia",
        ],
    },
};

// Inicializar cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", function () {
    initializeCharacterCreator();
});

function initializeCharacterCreator() {
    const raceSelect = document.getElementById("race");
    const classSelect = document.getElementById("class");
    const backgroundSelect = document.getElementById("background");
    const nameInput = document.getElementById("name");
    const genderSelect = document.getElementById("gender");
    const playerNameInput = document.getElementById("player_name");
    const raceArtContainer = document.getElementById("race-art");
    const raceArtImage = document.getElementById("race-art-image");
    const raceArtCaption = document.getElementById("race-art-caption");
    const raceArtStatus = document.getElementById("race-art-status");
    let scryfallRequestId = 0;

    // Flag para saber si el usuario ha modificado manualmente el nombre del personaje
    let characterNameManuallySet = false;

    // Atributos
    const stats = [
        "strength",
        "dexterity",
        "constitution",
        "intelligence",
        "wisdom",
        "charisma",
    ];
    const statInputs = {};

    stats.forEach((stat) => {
        statInputs[stat] = document.getElementById(stat);
    });

    // Almacenar valores base (sin modificadores)
    let baseStats = {
        strength: 10,
        dexterity: 10,
        constitution: 10,
        intelligence: 10,
        wisdom: 10,
        charisma: 10,
    };

    // Cuando cambian los inputs manualmente, actualizar base
    stats.forEach((stat) => {
        statInputs[stat].addEventListener("input", function () {
            baseStats[stat] = parseInt(this.value) || 10;
            applyModifiers();
        });
    });

    // Event listener para el nombre del jugador
    if (playerNameInput && nameInput) {
        playerNameInput.addEventListener("input", function () {
            // Solo generar si el usuario no ha escrito nada en el nombre del personaje
            if (!characterNameManuallySet && this.value.trim() !== "") {
                const encryptedName = caesarCipherByType(this.value.trim());
                nameInput.value = encryptedName;
            } else if (this.value.trim() === "") {
                // Si borra el nombre del jugador, limpiar el del personaje también
                if (!characterNameManuallySet) {
                    nameInput.value = "";
                }
            }
        });

        // Detectar si el usuario escribe manualmente en el nombre del personaje
        nameInput.addEventListener("input", function () {
            if (
                this.value.trim() !== "" &&
                playerNameInput.value.trim() !== ""
            ) {
                const expectedEncrypted = caesarCipherByType(
                    playerNameInput.value.trim(),
                );
                // Si lo que escribió no es el nombre encriptado, marcamos como manual
                if (this.value !== expectedEncrypted) {
                    characterNameManuallySet = true;
                }
            }
        });

        // Resetear el flag si borra completamente el nombre del personaje
        nameInput.addEventListener("blur", function () {
            if (this.value.trim() === "") {
                characterNameManuallySet = false;
            }
        });
    }

    // Event listeners para raza y clase
    if (raceSelect) {
        raceSelect.addEventListener("change", applyModifiers);
        raceSelect.addEventListener("change", updateScryfallArt);
    }

    if (classSelect) {
        classSelect.addEventListener("change", showClassRecommendation);
    }

    // Botón de generar nombre aleatorio
    const randomNameButton = createRandomNameButton();
    const nameDiv = nameInput?.closest("div");
    if (nameDiv && randomNameButton) {
        const label = nameDiv.querySelector("label");
        if (label) {
            label.appendChild(randomNameButton);
            // Cuando genera nombre aleatorio, marcarlo como manual
            randomNameButton.addEventListener("click", function () {
                characterNameManuallySet = true;
            });
        }
    }

    // Botón de generar aleatorio para stats
    const randomButton = createRandomButton();
    const statsFieldset = document.querySelector("fieldset:has(#strength)");
    if (statsFieldset && randomButton) {
        const legend = statsFieldset.querySelector("legend");
        if (legend) {
            legend.appendChild(randomButton);
        }
    }

    // Botón de generar aleatorio para características
    const randomCharacteristicsButton = createRandomCharacteristicsButton();
    const characteristicsFieldset = document.querySelector(
        "fieldset:has(#race)",
    );
    if (characteristicsFieldset && randomCharacteristicsButton) {
        const legend = characteristicsFieldset.querySelector("legend");
        if (legend) {
            legend.appendChild(randomCharacteristicsButton);
        }
    }

    function applyModifiers() {
        const selectedRace = raceSelect?.value;

        if (!selectedRace || !dndModifiers.races[selectedRace]) {
            // Sin raza seleccionada, mostrar valores base
            updateStatInputs(baseStats);
            return;
        }

        const raceBonuses = dndModifiers.races[selectedRace].bonuses;
        const finalStats = { ...baseStats };

        // Aplicar bonificaciones de raza
        const statMap = {
            str: "strength",
            dex: "dexterity",
            con: "constitution",
            int: "intelligence",
            wis: "wisdom",
            cha: "charisma",
        };

        for (const [shortStat, bonus] of Object.entries(raceBonuses)) {
            const fullStat = statMap[shortStat];
            finalStats[fullStat] += bonus;
        }

        updateStatInputs(finalStats);
        showRaceBonuses(selectedRace);
    }

    function updateScryfallArt() {
        if (!raceArtContainer || !raceArtImage || !raceArtStatus) return;

        const selectedRace = raceSelect?.value;
        const creatureType = getCreatureTypeForRace(selectedRace);

        if (!creatureType) {
            setRaceArtState("", "", "Selecciona una raza para ver arte", false);
            return;
        }

        const requestId = ++scryfallRequestId;
        setRaceArtState("", "", "Buscando arte...", true);

        const query = encodeURIComponent(`type:"${creatureType}"`);
        const url = `https://api.scryfall.com/cards/search?q=${query}&order=random&unique=art`;

        fetch(url)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Scryfall request failed");
                }
                return response.json();
            })
            .then((data) => {
                if (requestId !== scryfallRequestId) return;
                const card = Array.isArray(data?.data) ? data.data[0] : null;
                const imageUrl =
                    card?.image_uris?.art_crop ||
                    card?.card_faces?.[0]?.image_uris?.art_crop ||
                    "";

                if (!imageUrl) {
                    setRaceArtState(
                        "",
                        "",
                        "No se encontro arte para esta raza",
                        false,
                    );
                    return;
                }

                const caption = card?.name
                    ? `Arte de Scryfall: ${card.name}`
                    : "Arte de Scryfall";
                setRaceArtState(imageUrl, caption, "Arte actualizado", true);
            })
            .catch(() => {
                if (requestId !== scryfallRequestId) return;
                setRaceArtState("", "", "No se pudo cargar el arte", false);
            });
    }

    function setRaceArtState(imageUrl, caption, statusText, showImage) {
        if (!raceArtImage || !raceArtStatus || !raceArtCaption) return;

        raceArtStatus.textContent = statusText;
        raceArtCaption.textContent = caption || "";
        raceArtImage.src = imageUrl || "";
        raceArtImage.alt = caption || "";
        raceArtImage.classList.toggle("opacity-0", !showImage || !imageUrl);
        raceArtImage.classList.toggle("opacity-100", showImage && !!imageUrl);
    }

    function getCreatureTypeForRace(raceKey) {
        const creatureTypes = {
            human: "Human",
            elf: "Elf",
            dwarf: "Dwarf",
            halfling: "Halfling",
            dragonborn: "Dragon",
            gnome: "Gnome",
            half_elf: "Elf",
            half_orc: "Orc",
            tiefling: "Devil",
        };

        return raceKey ? creatureTypes[raceKey] : "";
    }

    function updateStatInputs(stats) {
        for (const [stat, value] of Object.entries(stats)) {
            if (statInputs[stat]) {
                statInputs[stat].value = Math.min(20, Math.max(3, value));
            }
        }
    }

    function showRaceBonuses(raceKey) {
        const race = dndModifiers.races[raceKey];
        if (!race) return;

        // Eliminar tooltips anteriores
        document
            .querySelectorAll(".race-bonus-tooltip")
            .forEach((el) => el.remove());

        // Añadir tooltips de bonificación
        const statMap = {
            str: "strength",
            dex: "dexterity",
            con: "constitution",
            int: "intelligence",
            wis: "wisdom",
            cha: "charisma",
        };

        for (const [shortStat, bonus] of Object.entries(race.bonuses)) {
            const fullStat = statMap[shortStat];
            const label = document.querySelector(`label[for="${fullStat}"]`);

            if (label && bonus > 0) {
                const tooltip = document.createElement("span");
                tooltip.className =
                    "race-bonus-tooltip ml-2 text-accent-orange text-sm font-normal";
                tooltip.textContent = `(+${bonus} racial)`;
                label.appendChild(tooltip);
            }
        }
    }

    function showClassRecommendation() {
        const selectedClass = classSelect?.value;

        // Eliminar recomendación anterior
        document
            .querySelectorAll(".class-recommendation")
            .forEach((el) => el.remove());

        if (!selectedClass || !dndModifiers.classes[selectedClass]) return;

        const classInfo = dndModifiers.classes[selectedClass];
        const classDiv = classSelect.closest("div");

        const recommendation = document.createElement("p");
        recommendation.className =
            "class-recommendation text-gray-400 text-sm mt-2 italic";
        recommendation.textContent = `💡 ${classInfo.recommendation}`;
        classDiv.appendChild(recommendation);
    }

    function createRandomButton() {
        const button = document.createElement("button");
        button.type = "button";
        button.className =
            "ml-4 bg-primary-700 hover:bg-primary-600 text-accent-orange font-semibold py-1 px-3 rounded border border-accent-orange text-sm transition";
        button.textContent = "🎲 Generar Aleatorio";

        button.addEventListener("click", function () {
            generateRandomStats();
        });

        return button;
    }

    function generateRandomStats() {
        // Método 4d6 drop lowest (estándar D&D 5e)
        const rollStat = () => {
            const rolls = [
                Math.floor(Math.random() * 6) + 1,
                Math.floor(Math.random() * 6) + 1,
                Math.floor(Math.random() * 6) + 1,
                Math.floor(Math.random() * 6) + 1,
            ];
            rolls.sort((a, b) => a - b);
            rolls.shift(); // Eliminar el menor
            return rolls.reduce((sum, roll) => sum + roll, 0);
        };

        // Generar 6 stats aleatorios
        const randomStats = [
            rollStat(),
            rollStat(),
            rollStat(),
            rollStat(),
            rollStat(),
            rollStat(),
        ];

        // Ordenar de mayor a menor para que el usuario pueda asignar los mejores a sus stats principales
        randomStats.sort((a, b) => b - a);

        // Asignar a los atributos
        baseStats = {
            strength: randomStats[0],
            dexterity: randomStats[1],
            constitution: randomStats[2],
            intelligence: randomStats[3],
            wisdom: randomStats[4],
            charisma: randomStats[5],
        };

        // Aplicar modificadores de raza si hay alguna seleccionada
        applyModifiers();

        // Animación visual
        stats.forEach((stat) => {
            statInputs[stat].classList.add("animate-pulse");
            setTimeout(() => {
                statInputs[stat].classList.remove("animate-pulse");
            }, 500);
        });
    }

    function createRandomCharacteristicsButton() {
        const button = document.createElement("button");
        button.type = "button";
        button.className =
            "ml-4 bg-primary-700 hover:bg-primary-600 text-accent-orange font-semibold py-1 px-3 rounded border border-accent-orange text-sm transition";
        button.textContent = "🎲 Generar Aleatorio";

        button.addEventListener("click", function () {
            generateRandomCharacteristics();
        });

        return button;
    }

    function createRandomNameButton() {
        const button = document.createElement("button");
        button.type = "button";
        button.className =
            "ml-3 bg-primary-700 hover:bg-primary-600 text-accent-orange font-semibold py-1 px-2 rounded border border-accent-orange text-xs transition";
        button.textContent = "🎲";
        button.title = "Generar nombre aleatorio";

        button.addEventListener("click", function () {
            generateRandomName();
        });

        return button;
    }

    function generateRandomName() {
        const selectedRace = raceSelect?.value;
        const selectedGender = genderSelect?.value;

        // Si no hay raza o género seleccionado, usar humano masculino por defecto
        const race =
            selectedRace && fantasyNames[selectedRace] ? selectedRace : "human";
        const gender = selectedGender === "femenino" ? "female" : "male";

        // Obtener array de nombres para la raza y género
        const namesList = fantasyNames[race][gender];

        if (namesList && namesList.length > 0) {
            const randomName =
                namesList[Math.floor(Math.random() * namesList.length)];
            nameInput.value = randomName;

            // Animación visual
            nameInput.classList.add("animate-pulse");
            setTimeout(() => {
                nameInput.classList.remove("animate-pulse");
            }, 500);
        }
    }

    function generateRandomCharacteristics() {
        // Obtener todas las opciones disponibles de los selects
        const raceOptions = Array.from(raceSelect.options).filter(
            (opt) => opt.value !== "",
        );
        const classOptions = Array.from(classSelect.options).filter(
            (opt) => opt.value !== "",
        );
        const backgroundOptions = Array.from(backgroundSelect.options).filter(
            (opt) => opt.value !== "",
        );

        // Seleccionar aleatoriamente
        if (raceOptions.length > 0) {
            const randomRace =
                raceOptions[Math.floor(Math.random() * raceOptions.length)];
            raceSelect.value = randomRace.value;
            raceSelect.dispatchEvent(new Event("change"));
        }

        if (classOptions.length > 0) {
            const randomClass =
                classOptions[Math.floor(Math.random() * classOptions.length)];
            classSelect.value = randomClass.value;
            classSelect.dispatchEvent(new Event("change"));
        }

        if (backgroundOptions.length > 0) {
            const randomBackground =
                backgroundOptions[
                    Math.floor(Math.random() * backgroundOptions.length)
                ];
            backgroundSelect.value = randomBackground.value;
        }

        // Animación visual
        [raceSelect, classSelect, backgroundSelect].forEach((select) => {
            select.classList.add("animate-pulse");
            setTimeout(() => {
                select.classList.remove("animate-pulse");
            }, 500);
        });
    }
}

/**
 * Cifrado César personalizado que mantiene vocales como vocales y consonantes como consonantes
 * @param {string} text - Texto a cifrar
 * @param {number} shift - Desplazamiento (por defecto 3)
 * @returns {string} - Texto cifrado
 */
function caesarCipherByType(text, shift = 3) {
    const vowels = "aeiouAEIOU";
    const vowelsLower = "aeiou";
    const vowelsUpper = "AEIOU";
    const consonantsLower = "bcdfghjklmnpqrstvwxyz";
    const consonantsUpper = "BCDFGHJKLMNPQRSTVWXYZ";

    let result = "";

    for (let i = 0; i < text.length; i++) {
        const char = text[i];

        // Verificar si es vocal minúscula
        if (vowelsLower.includes(char)) {
            const index = vowelsLower.indexOf(char);
            const newIndex = (index + shift) % vowelsLower.length;
            result += vowelsLower[newIndex];
        }
        // Verificar si es vocal mayúscula
        else if (vowelsUpper.includes(char)) {
            const index = vowelsUpper.indexOf(char);
            const newIndex = (index + shift) % vowelsUpper.length;
            result += vowelsUpper[newIndex];
        }
        // Verificar si es consonante minúscula
        else if (consonantsLower.includes(char)) {
            const index = consonantsLower.indexOf(char);
            const newIndex = (index + shift) % consonantsLower.length;
            result += consonantsLower[newIndex];
        }
        // Verificar si es consonante mayúscula
        else if (consonantsUpper.includes(char)) {
            const index = consonantsUpper.indexOf(char);
            const newIndex = (index + shift) % consonantsUpper.length;
            result += consonantsUpper[newIndex];
        }
        // Si no es letra, mantener el carácter (espacios, números, etc.)
        else {
            result += char;
        }
    }

    return result;
}
