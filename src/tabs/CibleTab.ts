import CibleRepository, {Cible} from "../repository/CibleRepository";
import DeleteButton from "../component/DeleteButton";
import PaysRepository from "../repository/PaysRepository";
import * as daysjs from "dayjs";
import Tab from "./Tab";

export default class CibleTab implements Tab<Cible>
{
	public selected: Cible;
	public models: Cible[];

	private readonly cibleRepo: CibleRepository;
	private readonly paysRepo: PaysRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly nom: HTMLInputElement;
	private readonly prenom: HTMLInputElement;
	private readonly dateNaissance: HTMLInputElement;
	private readonly pays: HTMLSelectElement;

	/**
	 * Initialize a new CibleTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("cible-list") as HTMLUListElement;
		this.code = document.getElementById("cible-header") as HTMLHeadingElement;
		this.nom = document.getElementById("cible-lastname") as HTMLInputElement;
		this.prenom = document.getElementById("cible-firstname") as HTMLInputElement;
		this.dateNaissance = document.getElementById("cible-birthdate") as HTMLInputElement;
		this.pays = document.getElementById("cible-pays") as HTMLSelectElement;
		this.cibleRepo = new CibleRepository();
		this.paysRepo = new PaysRepository();

		this.selected = null;
		this.nom.value = "";
		this.prenom.value = "";
		this.dateNaissance.value = "";
		this.pays.value = null;
		document.getElementById("cible-form").addEventListener("submit", this.submitModel.bind(this));
		document.getElementById("cible-new").addEventListener("click", this.onEntryAdd.bind(this));

		this.initialize();
		this.renderEntryView();
	}

	/**
	 * Render the tab content.
	 */
	public async initialize(): Promise<void>
	{
		try
		{
			// Cibles
			this.models = await this.cibleRepo.getAll();
			this.list.innerHTML = "";
			for (const cible of this.models)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${cible.code} ${cible.nom} ${cible.prenom} ${cible.dateNaissance}`;
				this.list.append(item);

				item.setAttribute("data-code", cible.code.toString());
				item.classList.add("list-item");
				item.addEventListener("click", this.onEntryClick.bind(this, item));

				// personal delete button
				const del = new DeleteButton<Cible, CibleRepository>(
					item, cible, this.cibleRepo);
				item.append(del.button);
			}

			// Pays
			const pays = await this.paysRepo.getAll();
			this.pays.innerHTML = "";
			for (const p of pays)
			{
				const item = document.createElement("option") as HTMLOptionElement;
				item.innerText = p.libelle;
				item.setAttribute("data-code", p.code.toString());
				item.setAttribute("data-libelle", p.libelle);
				this.pays.appendChild(item);
			}
			M.FormSelect.init(this.pays, { dropdownOptions: { container:document.body } });
		}
		catch (error)
		{
			console.log(error);
		}
	}

	/**
	 * Update the selected model data and send it to the backend.
	 */
	public async submitModel(e: Event): Promise<void>
	{
		e.preventDefault();
		const isNew = !this.selected;
		if (isNew)
			this.selected = {code: 0, dateNaissance: "", nom: "", pays: undefined, prenom: ""};

		// Cible
		this.selected.nom = this.nom.value;
		this.selected.prenom = this.prenom.value;
		this.selected.dateNaissance = this.dateNaissance.value;

		// Pays
		if (!this.pays.selectedOptions[0]) return;
		this.selected.pays = {
			...this.selected?.pays,
			code: parseInt(this.pays.selectedOptions[0].getAttribute("data-code"), 10),
			libelle: this.pays.selectedOptions[0].getAttribute("data-libelle")
		};

		isNew ? await this.cibleRepo.add(this.selected)
			: await this.cibleRepo.update(this.selected);
		await this.initialize();
		this.renderEntryView();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		// Cible
		this.code.innerText = this.selected?.code
			? `${this.selected?.prenom} ${this.selected?.nom}` : "Nouvelle Cible";
		this.nom.value = this.selected?.nom ?? "";
		this.prenom.value = this.selected?.prenom ?? "";
		this.dateNaissance.value = this.selected?.dateNaissance ?? "";
		M.Datepicker.init(this.dateNaissance, {
			container: document.body,
			format: "yyyy-mm-dd",
			defaultDate: daysjs(this.selected?.dateNaissance).toDate(),
			setDefaultDate: true
		});

		// Pays
		this.pays.childNodes.forEach((i: HTMLOptionElement) => i.selected =
			i.value === this.selected?.pays?.libelle);
		M.FormSelect.init(this.pays, { dropdownOptions: { container:document.body } });
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
