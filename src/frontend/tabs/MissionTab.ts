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

	public constructor(repo: MissionRepository, inputs: HTMLElement[], mission: Mission | null = null) {
		inputs.forEach((input) => {
			this.inputs.push(input);
		});
		this.mission = mission;
		this.repo = repo;
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
}