import JsonSerializable from "../JsonSerializable";
import Visee from "./Visee";

class Agent implements JsonSerializable
{
	private code: number | null;
	private nom: string;
	private prenom: string;
	private dateNaissance: Date;
	private codePays: number;

	/**
	 * Initailize a new Agent object.
	 */
	public constructor(code: number | null, nom: string, prenom: string,
		dateNaissance: Date, codePays: number)
	{
		this.code = code;
		this.nom = nom;
		this.prenom = prenom;
		this.dateNaissance = dateNaissance;
		this.codePays = codePays;
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

export default Agent;