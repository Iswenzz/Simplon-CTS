import Mission from "../model/Mission";
import MissionRepository from "../repository/MissionRepository";

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
	private titre : HTMLInputElement;

	public constructor(repo: MissionRepository, inputs: HTMLElement[], mission: Mission | null = null) {
		this.inputs = [];
		inputs.forEach((input) => {
			this.inputs.push(input);
		});
		this.mission = mission;
		this.repo = repo;

		this.titre = document.getElementById("mission-details-name") as HTMLInputElement;
	}

	public init(): void {
		this.repo.listAll();

		this.inputs.forEach((input) => {
			// TODO on leaving the input, updates the model's relevant values
			input.addEventListener("blur", () => {
				// this.mission.
			});
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
	}
	public getMission(): Mission {
		return this.mission;
	}
}