import Formattable from "../Formattable";
import JsonSerializable from "../JsonSerializable";
import Model from "./Model";

class Contact extends Model implements JsonSerializable, Formattable
{
	private code: number | null;
	private nom: string;
	private prenom: string;
	private dateNaissance: Date;
	private codePays: number;

	/**
	 * Initialize a new Contact object.
	 * @param code - The contact code.
	 * @param nom - The contact name.
	 * @param prenom - The contact firstname.
	 * @param dateNaissance - The contact birthdate.
	 * @param codePays - The contact country code.
	 */
	public constructor(code: number | null = null, nom = "",
		prenom = "", dateNaissance: Date = null, codePays = 0)
	{
		super();
		this.code = code;
		this.nom = nom;
		this.prenom = prenom;
		this.dateNaissance = dateNaissance ?? new Date();
		this.codePays = codePays;
	}

	public format(): string {
		return `${this.prenom} ${this.nom} (CO${this.code})`;
	}

	/**
	 * Get the value of code.
	 */
	public getCode(): number | null
	{
		return this.code;
	}

	/**
	 * Set the value of code.
	 */
	public setCode(code: number | null): void
	{
		this.code = code;
	}

	/**
	 * Get the value of nom.
	 */ 
	public getNom(): string
	{
		return this.nom;
	}

	/**
	 * Set the value of nom.
	 */ 
	public setNom(nom: string): void
	{
		this.nom = nom;
	}

	/**
	 * Get the value of prenom.
	 */ 
	public getPrenom(): string
	{
		return this.prenom;
	}

	/**
	 * Set the value of prenom.
	 */ 
	public setPrenom(prenom: string): void
	{
		this.prenom = prenom;
	}

	/**
	 * Get the value of dateNaissance.
	 */ 
	public getDateNaissance(): Date
	{
		return this.dateNaissance;
	}

	/**
	 * Set the value of dateNaissance.
	 */ 
	public setDateNaissance(dateNaissance: Date): void
	{
		this.dateNaissance = dateNaissance;
	}

	/**
	 * Get the value of codePays
	 */ 
	public getCodePays(): number
	{
		return this.codePays;
	}

	/**
	 * Set the value of codePays
	 */ 
	public setCodePays(codePays: number): void
	{
		this.codePays = codePays;
	}

	/**
	 * Serialize the object.
	 */
	public jsonSerialize(): Record<string, unknown>
	{
		return {
			code: this.getCode(),
			nom: this.getNom(),
			prenom: this.getPrenom(),
			dateNaissance: this.getDateNaissance().toLocaleDateString(),
			codePays: this.getCodePays()
		};
	}
}

export default Contact;