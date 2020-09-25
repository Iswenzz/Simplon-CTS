import * as dayjs from "dayjs";
import Mission from "../model/Mission";
import MissionRepository from "../repository/MissionRepository";
import swal from "sweetalert";
import InputComponent from "../component/InputComponent";
import PaysRepository from "../repository/PaysRepository";

export default class MissionTab {
	/**
	 * The model of the current selected mission
	 */
	private mission: Mission | null;
	/**
	 * The link with the API
	 */
	private missionRepo: MissionRepository;
	private paysRepo: PaysRepository;
	/**
	 * The HTML inputs (in the back-office)
	 */
	private inputs: HTMLElement[];
	// outputs
	private titre : HTMLInputElement;
	private description : HTMLTextAreaElement;
	private dateDebut : HTMLInputElement;
	private dateFin : HTMLInputElement;
	private typeMission : HTMLParagraphElement; // join avec MissionType & Spécialité
	private pays : HTMLSelectElement;
	private paysDesc : HTMLParagraphElement; // join avec Abrite
	private planqueDesc : HTMLParagraphElement; // join avec Abrite
	private planque : HTMLParagraphElement; // join avec Abrite

	public constructor(missionRepo: MissionRepository, inputs: HTMLElement[], mission: Mission | null = null) {
		this.inputs = [];
		inputs.forEach((input) => {
			this.inputs.push(input);
		});
		this.mission = mission;
		this.missionRepo = missionRepo;
		this.paysRepo = new PaysRepository();

		this.titre = document.getElementById("mission-details-name") as HTMLInputElement;
		this.description = document.getElementById("mission-details-desc") as HTMLTextAreaElement;
		this.dateDebut = document.getElementById("missions-details-date-start") as HTMLInputElement;
		this.dateFin = document.getElementById("missions-details-date-end") as HTMLInputElement;
	}

	public async init(): Promise<void> {
		this.missionRepo.listAll();

		const listPays = await this.paysRepo.getAll();
		const select = document.getElementById("mission-details-country-edit-select") as HTMLSelectElement;
		for (const pays of listPays) {
			const opt = document.createElement("option") as HTMLOptionElement;
			opt.value= pays.getCode().toString();
			opt.innerText = pays.getLibelle();
			select.append(opt);
		}

		this.inputs.forEach((input) => {
			// TODO on leaving the input, updates the model's relevant values
			input.addEventListener("blur", () => {
				// this.mission.
			});
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
			// handling the results
			if (res) {
				const missionModel = new Mission(null, input.getInput().value);
				this.updateMission(missionModel);
				console.log("Nouvelle mission : " + missionModel.format());
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