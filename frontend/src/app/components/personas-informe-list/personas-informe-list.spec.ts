import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PersonasInformeList } from './personas-informe-list';

describe('PersonasInformeList', () => {
  let component: PersonasInformeList;
  let fixture: ComponentFixture<PersonasInformeList>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PersonasInformeList],
    }).compileComponents();

    fixture = TestBed.createComponent(PersonasInformeList);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
