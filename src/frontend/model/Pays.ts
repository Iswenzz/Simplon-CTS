import Formattable from "./Formattable";
import JsonSerializable from "../util/JsonSerializable";
import Model from "./Model";

class Pays extends Model implements JsonSerializable, Formattable
{
	private code: number | null;
	private libelle: string;

	/**
	 * Initialize a new Pays object.
	 */
	public constructor(code: number | null, libelle: string)
	{
		super();
		this.code = code;
		this.libelle = libelle;
	}

	/**
	 * Format the model data.
	 */
	public format(): string {
		return `${this.libelle}`;
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

export default Pays;