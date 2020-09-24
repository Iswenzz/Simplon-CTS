import Formattable from "../Formattable";
import JsonSerializable from "../JsonSerializable";
import Model from "./Model";

class Planque extends Model implements JsonSerializable, Formattable
{
	private code: number | null;
	private adresse: string;
	private codePays: number | null;
	private codeTypePlanque: number | null;

	/**
	 * Initialize a new Planque object.
	 */
	public constructor(code: number | null = null, adresse = "", codePays: number | null = null, codeTypePlanque: number | null = null)
	{
		super();
		this.code = code;
		this.codePays = codePays;
		this.codeTypePlanque = codeTypePlanque;
		this.adresse = adresse;
	}

	/**
	 * Format the model data.
	 */
	public format(): string {
		return `${this.code} (${this.adresse})`;
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
	 * Get the value of adresse
	 */ 
	public getAdresse(): string
	{
		return this.adresse;
	}

	/**
	 * Set the value of adresse
	 */ 
	public setAdresse(adresse: string): void
	{
		this.adresse = adresse;
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
	 * Get the value of codeTypePlanque
	 */ 
	public getCodeTypePlanque(): number
	{
		return this.codeTypePlanque;
	}

	/**
	 * Set the value of codeTypePlanque
	 */ 
	public setCodeTypePlanque(codeTypePlanque: number): void
	{
		this.codeTypePlanque = codeTypePlanque;
	}

	/**
	 * Serialize the object.
	 */
	public jsonSerialize(): Record<string, unknown>
	{
		return {
			code: this.getCode(),
			adresse: this.getAdresse(),
			codePays: this.getCodePays(),
			codeTypePlanque: this.getCodeTypePlanque()
		};
	}
}

export default Planque;