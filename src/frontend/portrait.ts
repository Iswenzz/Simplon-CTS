import Avatars from "@dicebear/avatars";
import sprites from "@dicebear/avatars-human-sprites";
export const avatars = new Avatars(sprites);

export default class Portrait
{
	public seed: string;

	public constructor(firstName: string, lastName: string)
	{
		this.seed = firstName + lastName;
	}

	public createSVG(): string
	{
		return avatars.create("custom-seed");
	}
}
