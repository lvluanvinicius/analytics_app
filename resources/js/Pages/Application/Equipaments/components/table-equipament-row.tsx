import { Button } from "@/components/ui/button";
import { TableCell, TableRow } from "@/components/ui/table";
import { EquipamentInterface } from "@/types/equipament";
import { Link } from "@inertiajs/react";
import { Edit, Eye } from "lucide-react";
import { Delete } from "./delete";
import { ViewPorts } from "./view-ports";

interface TableEquipamentsProps {
    data: EquipamentInterface;
}

export function TableEquipamentRow({ data }: TableEquipamentsProps) {
    return (
        <TableRow>
            <TableCell>{data.id}</TableCell>
            <TableCell>{data.name}</TableCell>
            <TableCell>
                <ViewPorts data={data} />
            </TableCell>
            <TableCell>
                <div className="flex items-center gap-2">
                    <Link href={route("app.equipaments.show", data.uuid)}>
                        <Button size={"icon"}>
                            <Eye />
                        </Button>
                    </Link>

                    <Link href={route("app.equipaments.edit", data.uuid)}>
                        <Button size={"icon"}>
                            <Edit />
                        </Button>
                    </Link>

                    <Delete />
                </div>
            </TableCell>
        </TableRow>
    );
}
