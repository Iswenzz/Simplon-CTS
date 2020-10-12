import * as dayjs from "dayjs";
import Mission from "../model/Mission";
import MissionRepository from "../repository/MissionRepository";
import PaysRepository from "../repository/PaysRepository";
import PlanqueRepository from "../repository/PlanqueRepository";
import DeleteButton from "../component/DeleteButton";

export default class MissionTab
{
	// API links
	private readonly missionRepo: MissionRepository;
	private paysRepo: PaysRepository;
	private planqueRepo: PlanqueRepository;

	// inputs
	private list: HTMLUListElement;
	private titre: HTMLInputElement;
	private description: HTMLTextAreaElement;
	private dateDebut: HTMLInputElement;
	private dateFin: HTMLInputElement;
	private paysSelect: HTMLSelectElement;

	// outputs
	private typeMission: HTMLParagraphElement; 	// join avec MissionType & Spécialité
	private paysDesc: HTMLParagraphElement; 	// join avec Abrite
	private planqueDesc: HTMLParagraphElement; 	// join avec Abrite
	private planque: HTMLParagraphElement; 		// join avec Abrite

	/**
	 * Initialize a new MissionTab.
	 * @param missionRepo
	 */
	public constructor(missionRepo: MissionRepository, view: HTMLElement)
	{
		this.list = view as HTMLUListElement;
		this.missionRepo = missionRepo;
		this.paysRepo = new PaysRepository();
		this.planqueRepo = new PlanqueRepository();

		this.titre = document.getElementById("mission-details-name") as HTMLInputElement;
		this.description = document.getElementById("mission-details-desc") as HTMLTextAreaElement;
		this.dateDebut = document.getElementById("missions-details-date-start") as HTMLInputElement;
		this.dateFin = document.getElementById("missions-details-date-end") as HTMLInputElement;

		this.listAll();
	}

	/**
	 * List all missions in the view element.
	 */
	public async listAll(): Promise<void>
	{
		try
		{
			const missions = await this.missionRepo.getAll();
			// display all missions gotten from the DB
			for (const mission of missions)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = mission.format();
				this.list.append(item);

				item.setAttribute("id", "");
				item.classList.add("list-item");

				item.addEventListener("mouseenter", () => {
					console.log("enlevé la transparence");
					document.getElementById("mission-details").classList.remove("transparent");
				});

				// personal delete button
				const del = new DeleteButton<Mission, MissionRepository>(
					item, mission, this.missionRepo);
				item.append(del.getButton());
			}
		}
		catch (error)
		{
			console.log(error);
		}
	}

	/**
	 * Updates the detailed view of the missions
	 * @param mission - model of the Mission
	 */
	public updateMissionView(mission: Mission): void
	{
		this.titre.value = mission.getTitre();
		this.description.value = mission.getDescription();
		const dD = mission.getDateDebut() ? dayjs(mission.getDateDebut()) : dayjs();
		this.dateDebut.value =  dD.format("YYYY-MM-DD");
		const dF = mission.getDateFin() ? dayjs(mission.getDateFin()) : dayjs();
		this.dateFin.value = dF.format("YYYY-MM-DD");
	}
}
