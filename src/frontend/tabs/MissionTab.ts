import * as dayjs from "dayjs";
import Mission from "../model/Mission";
import MissionRepository from "../repository/MissionRepository";
import swal from "sweetalert";
import InputComponent from "../component/InputComponent";
import PaysRepository from "../repository/PaysRepository";
import PlanqueRepository from "../repository/PlanqueRepository";
import Pays from "../model/Pays";
import Checkbox from "../component/Checkbox";
import Abri from "../model/Abri";

export default class MissionTab {
	/**
	 * The model of the current selected mission
	 */
	private mission: Mission | null;
	private pays: Pays;
	/**
	 * Liste des planques sélectionnées pour cette mission
	 */
	private abris: Abri[];
	/**
	 * The link with the API
	 */
	private missionRepo: MissionRepository;
	private paysRepo: PaysRepository;
	private planqueRepo: PlanqueRepository;
	// inputs
	private titre : HTMLInputElement;
	private description : HTMLTextAreaElement;
	private dateDebut : HTMLInputElement;
	private dateFin : HTMLInputElement;
	private paysSelect : HTMLSelectElement;
	// outputs
	private typeMission : HTMLParagraphElement; // join avec MissionType & Spécialité
	private paysDesc : HTMLParagraphElement; // join avec Abrite
	private planqueDesc : HTMLParagraphElement; // join avec Abrite
	private planque : HTMLParagraphElement; // join avec Abrite

	public constructor(missionRepo: MissionRepository, mission: Mission | null = null) {
		this.mission = mission;
		this.missionRepo = missionRepo;
		this.paysRepo = new PaysRepository();
		this.planqueRepo = new PlanqueRepository();

		this.titre = document.getElementById("mission-details-name") as HTMLInputElement;
		this.description = document.getElementById("mission-details-desc") as HTMLTextAreaElement;
		this.dateDebut = document.getElementById("missions-details-date-start") as HTMLInputElement;
		this.dateFin = document.getElementById("missions-details-date-end") as HTMLInputElement;
	}

	public async init(): Promise<void> {
		this.missionRepo.listAll();

		// afficher la liste des pays
		const listPays = await this.paysRepo.getAll();
		this.paysSelect = document.getElementById("mission-details-country-edit-select") as HTMLSelectElement;
		for (const pays of listPays) {
			const opt = document.createElement("option") as HTMLOptionElement;
			opt.value= pays.getCode().toString();
			opt.innerText = pays.getLibelle();
			this.paysSelect.append(opt);
		}

		const planqueForm = document.getElementById("mission-details-hideout-check") as HTMLFormElement;
		this.paysSelect.addEventListener("change", async () => {
			// empties the list of planque
			this.abris = [];
			while (planqueForm.children[0]) {
				planqueForm.children[0].remove();
			}
			// fetch & build the new elements
			this.pays = new Pays(parseInt(this.paysSelect.value)); // reads the code
			this.pays = await this.paysRepo.get(this.pays); // fetch the values in the DB
			const planqueList = await this.planqueRepo.getAllInCountry(this.pays);

			if (planqueList.length > 0) {
				for (const planque of planqueList) {
					const item = new Checkbox(
						planque.getAdresse(),
						planque.getCode().toString(),
						this.mission.getCode(),
						planque.getCode()
					);
					planqueForm.append(item.getContainer());
					// màj de la liste d'abris quand modifs
					item.getInput().addEventListener("change", () => {
						console.log(this.abris);
						const abri = new Abri(this.mission.getCode(), planque.getCode());
						if (item.getInput().checked) { // ajout à la liste
							this.abris.push(abri);
						} else { // retire de la liste
							const i = this.abris.findIndex((el) => el == abri);
							this.abris.splice(i, 1);
						}
						console.log(this.abris);
					});
				}
			} else {
				const text = document.createElement("span");
				text.innerText = `Aucune planque en ${this.pays.getLibelle()} 😢`;
				planqueForm.append(text);
			}
		});

		// "add new" button
		document.getElementById("mission-list-add").addEventListener("click", async () => {
			// inner form
			const input = new InputComponent("text", "mission-list-add-name", "Titre de la mission :");
			// alert 
			const res = await swal({
				title: "Ajouter une nouvelle mission",
				buttons: ["Annuler", "Confirmer"],
				content: {element: input.getContainer()}
			});
			// handling the results : adding a new mission
			if (res) {
				this.mission = new Mission(null, input.getInput().value);
				this.updateMission(this.mission);
				this.missionRepo.addItem(this.mission);
				console.log("Nouvelle mission : " + this.mission.format());
			}
		});
	}

	// public reset();

	/**
	 * Updates the inner model of the mission
	 * @param mission - model of the mission
	 */
	public setMission(mission: Mission): void {
		this.mission = mission;
	}
	
	public getMission(): Mission {
		return this.mission;
	}

	/**
	 * Updates the detailed view of the missions
	 * @param mission - model of the Mission
	 */
	public updateMission(mission: Mission): void {
		this.setMission(mission);
		this.titre.value = this.mission.getTitre();
		this.description.value = this.mission.getDescription();
		const dD = this.mission.getDateDebut() ? dayjs(this.mission.getDateDebut()) : dayjs();
		this.dateDebut.value =  dD.format("YYYY-MM-DD");
		const dF = this.mission.getDateFin() ? dayjs(this.mission.getDateFin()) : dayjs();
		this.dateFin.value = dF.format("YYYY-MM-DD");
	}
}