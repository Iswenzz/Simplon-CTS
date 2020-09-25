import * as dayjs from "dayjs";
import Mission from "../model/Mission";
import MissionRepository from "../repository/MissionRepository";
import swal from "sweetalert";
import InputComponent from "../component/InputComponent";

export default class MissionTab {
	/**
	 * The model of the current selected mission
	 */
	private mission: Mission | null;
	/**
	 * The link with the API
	 */
	private repo: MissionRepository;
	/**
	 * The HTML inputs (in the back-office)
	 */
	private inputs: HTMLElement[];
	// outputs
	private titre : HTMLInputElement;
	private description : HTMLTextAreaElement;
	private dateDebut : HTMLInputElement;
	private dateFin : HTMLInputElement;
	private type : HTMLParagraphElement;

	public constructor(repo: MissionRepository, inputs: HTMLElement[], mission: Mission | null = null) {
		this.inputs = [];
		inputs.forEach((input) => {
			this.inputs.push(input);
		});
		this.mission = mission;
		this.repo = repo;

		this.titre = document.getElementById("mission-details-name") as HTMLInputElement;
		this.description = document.getElementById("mission-details-desc") as HTMLTextAreaElement;
	}

	public init(): void {
		this.repo.listAll();

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
				this.setMission(missionModel);
				console.log("Nouvelle mission : " + missionModel.format());
			}
		});
	}

	// public reset();

	/**
	 * Updates the detailed view of the missions
	 * @param mission - model of the Mission
	 */
	public setMission(mission: Mission): void {
		this.mission = mission;

		this.titre.value = this.mission.getTitre();
		this.description.value = this.mission.getDescription();
		this.dateDebut.value = dayjs(this.mission.getDateDebut()).format("YYYY-MM-DD");
		this.dateFin.value = dayjs(this.mission.getDateFin()).format("YYYY-MM-DD");
	}
	public getMission(): Mission {
		return this.mission;
	}
}