import JsonSerializable from "../JsonSerializable";

class Statut implements JsonSerializable
{
	private code: number | null;
	private libelle: string;

	/**
	 * Initailize a new Statut object.
	 */
	public constructor(code: number | null, libelle: string)
	{
		this.code = code;
		this.libelle = libelle;
	}

	/**
	 * Get the value of code
	 */ 
	public getCode(): number | null
	{
		return this.code;
	}

	/**
	 * Set the value of code
	 */ 
	public setCode(code: number | null): void
	{
		this.code = code;
	}

	/**
	 * Get the value of libelle
	 */ 
	public getLibelle(): string
	{
		return this.libelle;
	}

	/**
	 * Set the value of libelle
	 */ 
	public setLibelle(libelle: string): void
	{
		this.libelle = libelle;
	}

	/**
	 * Serialize the object.
	 */
	public jsonSerialize(): Record<string, unknown>
	{
		return {
			code: this.getCode(),
			libelle: this.getLibelle()
		};
	}
}
