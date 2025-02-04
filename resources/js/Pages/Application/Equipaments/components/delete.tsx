import { Button } from "@/components/ui/button";
import { Trash } from "lucide-react";

export function Delete() {
    return (
        <Button variant={"destructive"} size={"icon"}>
            <Trash />
        </Button>
    );
}
