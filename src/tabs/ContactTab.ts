import ContactRepository, {Contact} from "../repository/ContactRepository";
import DeleteButton from "../component/DeleteButton";
import PaysRepository from "../repository/PaysRepository";
import * as daysjs from "dayjs";
import Tab from "./Tab";

export default class ContactTab implements Tab<Contact>
{
	public selected: Contact;
	public models: Contact[];

	private readonly contactRepo: ContactRepository;
	private readonly paysRepo: PaysRepository;

	private readonly list: HTMLUListElement;
	private readonly code: HTMLHeadingElement;
	private readonly nom: HTMLInputElement;
	private readonly prenom: HTMLInputElement;
	private readonly dateNaissance: HTMLInputElement;
	private readonly pays: HTMLSelectElement;

	/**
	 * Initialize a new ContactTab.
	 */
	public constructor()
	{
		this.list = document.getElementById("contact-list") as HTMLUListElement;
		this.code = document.getElementById("contact-header") as HTMLHeadingElement;
		this.nom = document.getElementById("contact-lastname") as HTMLInputElement;
		this.prenom = document.getElementById("contact-firstname") as HTMLInputElement;
		this.dateNaissance = document.getElementById("contact-birthdate") as HTMLInputElement;
		this.pays = document.getElementById("contact-pays") as HTMLSelectElement;
		this.contactRepo = new ContactRepository();
		this.paysRepo = new PaysRepository();

		this.selected = null;
		this.nom.value = "";
		this.prenom.value = "";
		this.dateNaissance.value = "";
		this.pays.value = null;
		document.getElementById("contact-form").addEventListener("submit", this.submitModel.bind(this));
		document.getElementById("contact-new").addEventListener("click", this.onEntryAdd.bind(this));

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
			// Contacts
			this.models = await this.contactRepo.getAll();
			this.list.innerHTML = "";
			for (const contact of this.models)
			{
				const item = document.createElement("li") as HTMLLIElement;
				item.innerText = `${contact.code} ${contact.nom} ${contact.prenom} ${contact.dateNaissance}`;
				this.list.append(item);

				item.setAttribute("data-code", contact.code.toString());
				item.classList.add("list-item");
				item.addEventListener("click", this.onEntryClick.bind(this, item));

				// personal delete button
				const del = new DeleteButton<Contact, ContactRepository>(
					item, contact, this.contactRepo);
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

		// Contact
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

		isNew ? await this.contactRepo.add(this.selected)
			: await this.contactRepo.update(this.selected);
		await this.initialize();
		this.renderEntryView();
	}

	/**
	 * Render the entry to the DOM.
	 */
	public renderEntryView(): void
	{
		// Contact
		this.code.innerText = this.selected?.code
			? `${this.selected?.prenom} ${this.selected?.nom}` : "Nouveau Contact";
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
