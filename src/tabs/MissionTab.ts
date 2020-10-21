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

	private readonly missionRepo: MissionRepository;
	private readonly contactRepo: ContactRepository;
	private readonly cibleRepo: CibleRepository;
	private readonly agentRepo: AgentRepository;
	private readonly planqueRepo: PlanqueRepository;
	private readonly statutRepo: StatutRepository;
	private readonly typeMissionRepo: TypeMissionRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly titre: HTMLInputElement;
	private readonly description: HTMLTextAreaElement;
	private readonly dateDebut: HTMLInputElement;
	private readonly dateFin: HTMLInputElement;
	private readonly contacts: HTMLSelectElement;
	private readonly cibles: HTMLSelectElement;
	private readonly agents: HTMLSelectElement;
	private readonly planques: HTMLSelectElement;
	private readonly statut: HTMLSelectElement;
	private readonly type: HTMLSelectElement;
	private readonly specialite: HTMLSelectElement;

	/**
	 * Initialize a new MissionTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("mission-list") as HTMLUListElement;
		this.code = document.getElementById("mission-header") as HTMLHeadingElement;
		this.titre = document.getElementById("mission-title") as HTMLInputElement;
		this.description = document.getElementById("mission-description") as HTMLTextAreaElement;
		this.dateDebut = document.getElementById("mission-date-start") as HTMLInputElement;
		this.dateFin = document.getElementById("mission-date-end") as HTMLInputElement;
		this.contacts = document.getElementById("mission-contacts") as HTMLSelectElement;
		this.cibles = document.getElementById("mission-cibles") as HTMLSelectElement;
		this.agents = document.getElementById("mission-agents") as HTMLSelectElement;
		this.planques = document.getElementById("mission-hideouts") as HTMLSelectElement;
		this.statut = document.getElementById("mission-statut") as HTMLSelectElement;
		this.type = document.getElementById("mission-type") as HTMLSelectElement;
		this.specialite = document.getElementById("mission-specialite") as HTMLSelectElement;

		this.missionRepo = new MissionRepository();
		this.contactRepo = new ContactRepository();
		this.cibleRepo = new CibleRepository();
		this.agentRepo = new AgentRepository();
		this.planqueRepo = new PlanqueRepository();
		this.statutRepo = new StatutRepository();
		this.typeMissionRepo = new TypeMissionRepository();

		this.selected = null;
		this.titre.value = "";
		this.description.value = "";
		this.dateDebut.value = null;
		this.dateFin.value = null;
		this.contacts.value = null;
		this.cibles.value = null;
		this.agents.value = null;
		this.planques.value = null;
		this.statut.value = null;
		this.type.value = null;
		this.specialite.value = null;

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

			// Contacts
			this.modelsContact = await this.contactRepo.getAll();
			this.contacts.innerHTML = "";
			for (const c of this.modelsContact)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = `${c.prenom} ${c.nom}`;
				item.setAttribute("data-code", c.code.toString());
				this.contacts.appendChild(item);
			}
			M.FormSelect.init(this.contacts, { dropdownOptions: { container:document.body } });

			// Statut
			this.modelsStatut = await this.statutRepo.getAll();
			this.statut.innerHTML = "";
			for (const s of this.modelsStatut)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = s.libelle;
				item.setAttribute("data-code", s.code.toString());
				this.contacts.appendChild(item);
			}
			M.FormSelect.init(this.contacts, { dropdownOptions: { container:document.body } });

			// TypeMission
			this.modelsTypeMission = await this.typeMissionRepo.getAll();
			this.statut.innerHTML = "";
			for (const t of this.modelsTypeMission)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = t.libelle;
				item.setAttribute("data-code", t.code.toString());
				this.contacts.appendChild(item);
			}
			M.FormSelect.init(this.contacts, { dropdownOptions: { container:document.body } });
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
		this.selected.dateDebut = this.dateDebut.value;
		this.selected.dateFin = this.dateFin.value;

		// Statut
		if (!this.statut.selectedOptions[0]) return;
		const selectedStatut = this.modelsStatut.find(i =>
			i.code === parseInt(this.statut.selectedOptions[0].getAttribute("data-code"), 10));
		this.selected.statut = { ...this.selected?.statut, ...selectedStatut };

		// TypeMission
		if (!this.type.selectedOptions[0]) return;
		const selectedType = this.modelsStatut.find(i =>
			i.code === parseInt(this.type.selectedOptions[0].getAttribute("data-code"), 10));
		this.selected.type = { ...this.selected?.type, ...selectedType };

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
		this.dateDebut.value = this.selected?.dateDebut ?? "";
		M.Datepicker.init(this.dateDebut, {
			container: document.body,
			format: "yyyy-mm-dd",
			defaultDate: daysjs(this.selected?.dateDebut).toDate(),
			setDefaultDate: true
		});
		this.dateFin.value = this.selected?.dateFin ?? "";
		M.Datepicker.init(this.dateFin, {
			container: document.body,
			format: "yyyy-mm-dd",
			defaultDate: daysjs(this.selected?.dateFin).toDate(),
			setDefaultDate: true
		});

		// Statut
		this.statut.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selected?.statut?.libelle);
		M.FormSelect.init(this.statut, { dropdownOptions: { container:document.body } });

		// TypeMission
		this.type.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selected?.type?.libelle);
		M.FormSelect.init(this.type, { dropdownOptions: { container:document.body } });
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
