import DeleteButton from "../component/DeleteButton";
import MissionRepository, {Mission} from "../repository/MissionRepository";
import PaysRepository, {Pays} from "../repository/PaysRepository";
import PlanqueRepository, {Planque} from "../repository/PlanqueRepository";
import AgentRepository, {Agent} from "../repository/AgentRepository";
import CibleRepository, {Cible} from "../repository/CibleRepository";
import ContactRepository, {Contact} from "../repository/ContactRepository";
import * as daysjs from "dayjs";
import Tab from "./Tab";
import StatutRepository, {Statut} from "../repository/StatutRepository";
import TypeMissionRepository, {TypeMission} from "../repository/TypeMissionRepository";
import DatePickerComponent from "../component/DatePickerComponent";
import SelectComponent from "../component/SelectComponent";
import SpecialiteRepository, {Specialite} from "../repository/SpecialiteRepository";

export default class MissionTab implements Tab<Mission>
{
	public selected: Mission;
	public models: Mission[];
	public modelsContact: Contact[];
	public modelsCible: Cible[];
	public modelsAgent: Agent[];
	public modelsPlanque: Planque[];
	public modelsStatut: Statut[];
	public modelsTypeMission: TypeMission[];
	public modelsSpecialite: Specialite[];

	private readonly missionRepo: MissionRepository;
	private readonly contactRepo: ContactRepository;
	private readonly cibleRepo: CibleRepository;
	private readonly agentRepo: AgentRepository;
	private readonly planqueRepo: PlanqueRepository;
	private readonly statutRepo: StatutRepository;
	private readonly typeMissionRepo: TypeMissionRepository;
	private readonly specialiteRepo: SpecialiteRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly titre: HTMLInputElement;
	private readonly description: HTMLTextAreaElement;
	private readonly dateDebut: DatePickerComponent;
	private readonly dateFin: DatePickerComponent;
	private readonly contacts: SelectComponent<Contact>;
	private readonly cibles: SelectComponent<Cible>;
	private readonly agents: SelectComponent<Agent>;
	private readonly planques: SelectComponent<Planque>;
	private readonly statut: SelectComponent<Statut>;
	private readonly type: SelectComponent<TypeMission>;
	private readonly specialite: SelectComponent<Specialite>;

	/**
	 * Initialize a new MissionTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("mission-list") as HTMLUListElement;
		this.code = document.getElementById("mission-header") as HTMLHeadingElement;
		this.titre = document.getElementById("mission-title") as HTMLInputElement;
		this.description = document.getElementById("mission-description") as HTMLTextAreaElement;
		this.dateDebut = new DatePickerComponent(document.getElementById("mission-date-start") as HTMLInputElement);
		this.dateFin = new DatePickerComponent(document.getElementById("mission-date-end") as HTMLInputElement);
		this.contacts = new SelectComponent<Contact>(document.getElementById("mission-contacts") as HTMLSelectElement);
		this.cibles = new SelectComponent<Cible>(document.getElementById("mission-cibles") as HTMLSelectElement);
		this.agents = new SelectComponent<Agent>(document.getElementById("mission-agents") as HTMLSelectElement);
		this.planques = new SelectComponent<Planque>(document.getElementById("mission-hideouts") as HTMLSelectElement);
		this.statut = new SelectComponent<Statut>(document.getElementById("mission-statut") as HTMLSelectElement);
		this.type = new SelectComponent<TypeMission>(document.getElementById("mission-type") as HTMLSelectElement);
		this.specialite = new SelectComponent<Specialite>(document.getElementById("mission-specialite") as HTMLSelectElement);

		this.missionRepo = new MissionRepository();
		this.contactRepo = new ContactRepository();
		this.cibleRepo = new CibleRepository();
		this.agentRepo = new AgentRepository();
		this.planqueRepo = new PlanqueRepository();
		this.statutRepo = new StatutRepository();
		this.typeMissionRepo = new TypeMissionRepository();
		this.specialiteRepo = new SpecialiteRepository();

		this.selected = null;
		this.titre.value = "";
		this.description.value = "";

		document.getElementById("mission-form").addEventListener("submit", this.submitModel.bind(this));
		document.getElementById("mission-new").addEventListener("click", this.onEntryAdd.bind(this));
		document.getElementById("mission-tab").addEventListener("click", this.initialize.bind(this));
	}

	/**
	 * Render the tab content.
	 */
	public async initialize(): Promise<void>
	{
		try
		{
			// Missions
			this.models = await this.missionRepo.getAll();
			this.list.innerHTML = "";
			for (const mission of this.models)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${mission.code} ${mission.titre}`;
				this.list.append(item);

				item.setAttribute("data-code", mission.code.toString());
				item.classList.add("list-item");
				item.addEventListener("click", this.onEntryClick.bind(this, item));

				// personal delete button
				const del = new DeleteButton<Mission, MissionRepository>(
					item, mission, this.missionRepo);
				item.append(del.button);
			}

			// Statut
			this.modelsStatut = await this.statutRepo.getAll();
			this.statut.initialize(this.modelsStatut, "libelle");

			// TypeMission
			this.modelsTypeMission = await this.typeMissionRepo.getAll();
			this.type.initialize(this.modelsTypeMission, "libelle");

			// Specialite
			this.modelsSpecialite = await this.specialiteRepo.getAll();
			this.specialite.initialize(this.modelsSpecialite, "libelle");
		}
		catch (error)
		{
			console.log(error);
		}
		this.renderEntryView();
	}

	/**
	 * Update the selected model data and send it to the backend.
	 */
	public async submitModel(e: Event): Promise<void>
	{
		e.preventDefault();
		const isNew = !this.selected;
		if (isNew)
		{
			this.selected = {
				agents: [],
				cibles: [],
				code: 0,
				contacts: [],
				dateDebut: "",
				dateFin: "",
				description: "",
				planques: [],
				specialite: undefined,
				statut: undefined,
				titre: "",
				type: undefined
			};
		}

		// Mission
		this.selected.titre = this.titre.value;
		this.selected.description = this.description.value;
		this.selected.dateDebut = this.dateDebut.picker.value;
		this.selected.dateFin = this.dateFin.picker.value;
		this.selected.statut = this.statut.getSelection() ?? this.selected.statut;
		this.selected.type = this.type.getSelection() ?? this.selected.type;
		this.selected.specialite = this.specialite.getSelection() ?? this.selected.specialite;

		isNew ? await this.missionRepo.add(this.selected)
			: await this.missionRepo.update(this.selected);
		await this.initialize();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		// Mission
		this.code.innerText = this.selected?.code
			? `${this.selected?.titre}` : "Nouvelle Mission";
		this.titre.value = this.selected?.titre ?? "";
		this.description.value = this.selected?.description ?? "";
		this.dateDebut.render(this.selected?.dateDebut, "yyyy-mm-dd");
		this.dateFin.render(this.selected?.dateFin, "yyyy-mm-dd");
		this.statut.render(this.selected?.statut?.code);
		this.type.render(this.selected?.type?.code);
		this.specialite.render(this.selected?.specialite?.code);
	}

	/**
	 * Callback on entry click.
	 * @param sender - The entry element.
	 */
	public onEntryClick(sender: HTMLLIElement): void
	{
		const idx: number = parseInt(sender.getAttribute("data-code"), 10);
		this.selected = this.models.find(p => p.code === idx);
		this.renderEntryView();
	}

	/**
	 * Callback on entry add.
	 */
	public onEntryAdd(): void
	{
		this.selected = null;
		this.renderEntryView();
	}
}
